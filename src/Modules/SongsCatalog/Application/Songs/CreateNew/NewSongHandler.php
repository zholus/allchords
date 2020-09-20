<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\CreateNew;

use App\Modules\SongsCatalog\Domain\Authors\AuthorId;
use App\Modules\SongsCatalog\Domain\Authors\AuthorNotFoundException;
use App\Modules\SongsCatalog\Domain\Authors\AuthorRepository;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Creators\CreatorNotFoundException;
use App\Modules\SongsCatalog\Domain\Creators\CreatorRepository;
use App\Modules\SongsCatalog\Domain\Genres\GenreId;
use App\Modules\SongsCatalog\Domain\Genres\GenreNotFoundException;
use App\Modules\SongsCatalog\Domain\Genres\GenreRepository;
use App\Modules\SongsCatalog\Domain\Songs\Song;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;

class NewSongHandler
{
    private AuthorRepository $authors;
    private CreatorRepository $creators;
    private GenreRepository $genres;
    private SongRepository $songs;

    public function __construct(
        AuthorRepository $authors,
        CreatorRepository $creators,
        GenreRepository $genres,
        SongRepository $songs
    ) {
        $this->authors = $authors;
        $this->creators = $creators;
        $this->genres = $genres;
        $this->songs = $songs;
    }

    public function __invoke(NewSongCommand $command): void
    {
        $authorId = new AuthorId($command->getAuthorId());
        $genreId = new GenreId($command->getGenreId());
        $creatorId = new CreatorId($command->getCreatorId());

        $author = $this->authors->getById($authorId);

        if ($author === null) {
            throw AuthorNotFoundException::withId($authorId);
        }

        $genre = $this->genres->getById($genreId);

        if ($genre === null) {
            throw GenreNotFoundException::withId($genreId);
        }

        if ($this->creators->getById($creatorId) === null) {
            throw CreatorNotFoundException::withId($creatorId);
        }

        $song = Song::new(
            $this->songs->nextIdentity(),
            $author,
            $creatorId,
            $genre,
            $command->getTitle(),
            $command->getChords()
        );

        $this->songs->add($song);
    }
}

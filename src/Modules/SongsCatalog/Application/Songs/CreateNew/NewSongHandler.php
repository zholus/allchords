<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Songs\CreateNew;

use App\Modules\SongsCatalog\Domain\Artists\ArtistId;
use App\Modules\SongsCatalog\Domain\Artists\ArtistNotFoundException;
use App\Modules\SongsCatalog\Domain\Artists\ArtistRepository;
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
    private ArtistRepository $artists;
    private CreatorRepository $creators;
    private GenreRepository $genres;
    private SongRepository $songs;

    public function __construct(
        ArtistRepository $artists,
        CreatorRepository $creators,
        GenreRepository $genres,
        SongRepository $songs
    ) {
        $this->artists = $artists;
        $this->creators = $creators;
        $this->genres = $genres;
        $this->songs = $songs;
    }

    public function __invoke(NewSongCommand $command): string
    {
        $artistId = new ArtistId($command->getArtistId());
        $genreId = new GenreId($command->getGenreId());
        $creatorId = new CreatorId($command->getCreatorId());

        $artist = $this->artists->getById($artistId);

        if ($artist === null) {
            throw ArtistNotFoundException::withId($artistId);
        }

        $genre = $this->genres->getById($genreId);

        if ($genre === null) {
            throw GenreNotFoundException::withId($genreId);
        }

        $creator = $this->creators->getById($creatorId);

        if ($creator === null) {
            throw CreatorNotFoundException::withId($creatorId);
        }

        $song = Song::new(
            $this->songs->nextIdentity(),
            $artist,
            $creator,
            $genre,
            $command->getTitle(),
            $command->getChords()
        );

        $this->songs->add($song);

        return $song->getId()->toString();
    }
}

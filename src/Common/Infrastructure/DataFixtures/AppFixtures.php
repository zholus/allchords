<?php

namespace App\Common\Infrastructure\DataFixtures;

use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\Comments\Domain\Authors\Author;
use App\Modules\Comments\Domain\Authors\AuthorId;
use App\Modules\Comments\Domain\Songs\Song as CommentSong;
use App\Modules\Comments\Domain\Songs\SongId as CommandSongId;
use App\Modules\SongsCatalog\Domain\Artists\Artist;
use App\Modules\SongsCatalog\Domain\Artists\ArtistId;
use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Genres\Genre;
use App\Modules\SongsCatalog\Domain\Genres\GenreId;
use App\Modules\SongsCatalog\Domain\Songs\Song;
use App\Modules\SongsCatalog\Domain\Songs\SongId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $this->persistUser($manager);
        $creator = $this->persistCreator($manager, $user);

        $artist = $this->buildArtist();
        $genre = $this->buildGenre();

        $manager->persist($artist);
        $manager->persist($genre);
        $song = $this->persistSong($manager, $artist, $creator, $genre);

        $this->persistCommentAuthor($manager, $user);
        $this->persistCommentSong($manager, $song);

        $manager->flush();
    }

    private function persistUser(ObjectManager $manager)
    {
        $user = $this->buildUser();

        $manager->persist($user);

        return $user;
    }

    private function buildUser(): User
    {
        return User::register(
            new UserId($this->uuid()),
            'test1',
            'test@gmail.com',
            password_hash('123123', PASSWORD_BCRYPT)
        );
    }

    private function buildArtist(): Artist
    {
        return new Artist(
            new ArtistId($this->uuid()),
            'title'
        );
    }

    private function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    private function buildGenre(): Genre
    {
        return new Genre(
            new GenreId($this->uuid()),
            'title'
        );
    }

    private function persistCreator(ObjectManager $manager, User $user): Creator
    {
        $creator = $this->buildCreator($user);

        $manager->persist($creator);

        return $creator;
    }

    private function buildCreator(User $user): Creator
    {
        return new Creator(
            new CreatorId($user->getId()->toString()),
            $user->getUsername()
        );
    }

    private function persistSong(ObjectManager $manager, Artist $artist, Creator $creator, Genre $genre)
    {
        $song = $this->buildSong($artist, $creator, $genre);

        $manager->persist($song);

        return $song;
    }

    private function buildSong(Artist $artist, Creator $creator, Genre $genre): Song
    {
        return new Song(
            new SongId($this->uuid()),
            $artist,
            $creator,
            $genre,
            'title',
            'chords',
            new \DateTimeImmutable()
        );
    }

    private function persistCommentAuthor(ObjectManager $manager, User $user)
    {
        $author = new Author(
            new AuthorId($user->getId()->toString()),
            $user->getUsername()
        );

        $manager->persist($author);

        return $author;
    }

    private function persistCommentSong(ObjectManager $manager, Song $song)
    {
        $song = new CommentSong(new CommandSongId($song->getId()->toString()), new ArrayCollection());

        $manager->persist($song);

        return $song;
    }
}

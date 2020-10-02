<?php

namespace App\Common\Infrastructure\DataFixtures;

use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\SongsCatalog\Domain\Artists\Artist;
use App\Modules\SongsCatalog\Domain\Artists\ArtistId;
use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Genres\Genre;
use App\Modules\SongsCatalog\Domain\Genres\GenreId;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
            '123123'
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

    private function persistCreator(ObjectManager $manager, User $user)
    {
        $creator = $this->buildCreator($user);

        $manager->persist($creator);
    }

    private function buildCreator(User $user): Creator
    {
        return new Creator(
            new CreatorId($user->getId()->toString()),
            $user->getUsername()
        );
    }
}

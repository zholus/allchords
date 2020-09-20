<?php

namespace App\Common\Infrastructure\DataFixtures;

use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\SongsCatalog\Domain\Authors\Author;
use App\Modules\SongsCatalog\Domain\Authors\AuthorId;
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

        $author = $this->buildAuthor();
        $genre = $this->buildGenre();

        $manager->persist($author);
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

    private function buildAuthor(): Author
    {
        return new Author(
            new AuthorId($this->uuid()),
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
}

<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Genres;

use App\Modules\SongsCatalog\Domain\Genres\Genre;
use App\Modules\SongsCatalog\Domain\Genres\GenreId;
use App\Modules\SongsCatalog\Domain\Genres\GenreRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class DoctrineGenreRepository extends ServiceEntityRepository implements GenreRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    public function nextIdentity(): GenreId
    {
        return new GenreId(Uuid::uuid4()->toString());
    }

    public function getById(GenreId $id): ?Genre
    {
        return $this->find($id);
    }

    public function add(Genre $genre): void
    {
        $this->getEntityManager()->persist($genre);
    }
}

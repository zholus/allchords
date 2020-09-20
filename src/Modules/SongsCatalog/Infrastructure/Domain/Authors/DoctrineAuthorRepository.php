<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Authors;

use App\Modules\SongsCatalog\Domain\Authors\Author;
use App\Modules\SongsCatalog\Domain\Authors\AuthorId;
use App\Modules\SongsCatalog\Domain\Authors\AuthorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class DoctrineAuthorRepository extends ServiceEntityRepository implements AuthorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function nextIdentity(): AuthorId
    {
        return new AuthorId(Uuid::uuid4()->toString());
    }

    public function getById(AuthorId $id): ?Author
    {
        return $this->find($id);
    }

    public function add(Author $author): void
    {
        $this->getEntityManager()->persist($author);
    }
}

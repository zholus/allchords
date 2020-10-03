<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Domain\Authors;

use App\Modules\Comments\Domain\Authors\Author;
use App\Modules\Comments\Domain\Authors\AuthorId;
use App\Modules\Comments\Domain\Authors\AuthorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineAuthorRepository extends ServiceEntityRepository implements AuthorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function add(Author $author): void
    {
        $this->getEntityManager()->persist($author);
    }

    public function getById(AuthorId $id): ?Author
    {
        return $this->find($id);
    }

    public function getByUsername(string $username): ?Author
    {
        return $this->findOneBy(['username' => $username]);
    }
}

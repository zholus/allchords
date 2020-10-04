<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Domain\Songs;

use App\Modules\Comments\Domain\Songs\Comment;
use App\Modules\Comments\Domain\Songs\CommentId;
use App\Modules\Comments\Domain\Songs\CommentRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class DoctrineCommentRepository extends ServiceEntityRepository implements CommentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function getById(CommentId $id): ?Comment
    {
        return $this->find($id);
    }
}

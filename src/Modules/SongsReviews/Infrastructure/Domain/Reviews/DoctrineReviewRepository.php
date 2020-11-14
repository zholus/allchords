<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Domain\Reviews;

use App\Modules\SongsReviews\Domain\Reviews\Review;
use App\Modules\SongsReviews\Domain\Reviews\ReviewId;
use App\Modules\SongsReviews\Domain\Reviews\ReviewRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

final class DoctrineReviewRepository extends ServiceEntityRepository implements ReviewRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function nextIdentity(): ReviewId
    {
        return new ReviewId(Uuid::uuid4()->toString());
    }

    public function add(Review $review): void
    {
        $this->getEntityManager()->persist($review);
    }
}

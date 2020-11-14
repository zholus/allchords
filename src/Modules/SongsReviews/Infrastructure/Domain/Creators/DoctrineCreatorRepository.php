<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Domain\Creators;

use App\Modules\SongsReviews\Domain\Creators\Creator;
use App\Modules\SongsReviews\Domain\Creators\CreatorId;
use App\Modules\SongsReviews\Domain\Creators\CreatorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineCreatorRepository extends ServiceEntityRepository implements CreatorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creator::class);
    }

    public function add(Creator $creator): void
    {
        $this->getEntityManager()->persist($creator);
    }

    public function getById(CreatorId $creatorId): ?Creator
    {
        return $this->find($creatorId);
    }
}

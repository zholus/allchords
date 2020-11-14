<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Domain\Artists;

use App\Modules\SongsReviews\Domain\Artists\Artist;
use App\Modules\SongsReviews\Domain\Artists\ArtistId;
use App\Modules\SongsReviews\Domain\Artists\ArtistRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineArtistRepository extends ServiceEntityRepository implements ArtistRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function getById(ArtistId $id): ?Artist
    {
        return $this->find($id);
    }

    public function getManyById(array $ids): array
    {
        return $this->findBy([
            'id' => $ids
        ]);
    }

    public function getPaginated(?string $artistTitle, int $limit, int $offset): array
    {
        $builder = $this->createQueryBuilder('a');

        if (!empty($artistTitle)) {
            $builder->where('a.title LIKE :title');
            $builder->setParameter('title', '%' . $artistTitle . '%');
        }

        $builder
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        $query = $builder->getQuery();

        return $query->getResult();
    }

    public function getArtistsCount(): int
    {
        $builder = $this->createQueryBuilder('a');
        $query = $builder->select('count(a.id)')->getQuery();

        return (int)$query->getSingleScalarResult();
    }
}

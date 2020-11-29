<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Songs;

use App\Modules\SongsCatalog\Domain\Songs\Song;
use App\Modules\SongsCatalog\Domain\Songs\SongId;
use App\Modules\SongsCatalog\Domain\Songs\SongRepository;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class DoctrineSongRepository extends ServiceEntityRepository implements SongRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    public function nextIdentity(): SongId
    {
        return new SongId(Uuid::uuid4()->toString());
    }

    public function add(Song $song): void
    {
        $this->getEntityManager()->persist($song);
    }

    public function getById(SongId $id): ?Song
    {
        return $this->find($id);
    }

    /**
     * @return Song[]
     */
    public function getSongsFiltered(int $limit, int $offset, ?DateTimeImmutable $creationDate): array
    {
        $builder = $this->createQueryBuilder('s');
        $builder->setMaxResults($limit);
        $builder->setFirstResult($offset);

        if ($creationDate !== null) {
            $builder->where('s.createdAt >= :date_from', 's.createdAt <= :date_to');
            $builder->setParameter(':date_from', $creationDate->setTime(0, 0));
            $builder->setParameter(':date_to', $creationDate->setTime(23, 59, 59, 9999));
        }

        $query = $builder->getQuery();

        return $query->getResult();
    }

    public function getSongsFilteredCount(int $limit, int $offset, ?DateTimeImmutable $creationDate): int
    {
        $builder = $this->createQueryBuilder('s');
        $builder->select('count(s.id)');
        $builder->setMaxResults($limit);
        $builder->setFirstResult($offset);

        if ($creationDate !== null) {
            $builder->where('s.createdAt >= :date_from', 's.createdAt <= :date_to');
            $builder->setParameter(':date_from', $creationDate->setTime(0, 0));
            $builder->setParameter(':date_to', $creationDate->setTime(23, 59, 59, 9999));
        }

        $query = $builder->getQuery();

        return (int)$query->getSingleScalarResult();
    }
}

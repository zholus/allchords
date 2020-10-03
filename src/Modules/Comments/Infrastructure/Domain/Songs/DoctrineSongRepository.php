<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Domain\Songs;

use App\Modules\Comments\Domain\Songs\Song;
use App\Modules\Comments\Domain\Songs\SongId;
use App\Modules\Comments\Domain\Songs\SongRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineSongRepository extends ServiceEntityRepository implements SongRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    public function add(Song $song): void
    {
        $this->getEntityManager()->persist($song);
    }

    public function getById(SongId $song): ?Song
    {
        return $this->find($song);
    }
}

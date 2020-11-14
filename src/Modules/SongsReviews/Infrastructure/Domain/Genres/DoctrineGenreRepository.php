<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Domain\Genres;

use App\Modules\SongsReviews\Domain\Genres\Genre;
use App\Modules\SongsReviews\Domain\Genres\GenreId;
use App\Modules\SongsReviews\Domain\Genres\GenreRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineGenreRepository extends ServiceEntityRepository implements GenreRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    public function getById(GenreId $id): ?Genre
    {
        return $this->find($id);
    }

    public function getGenresCount(): int
    {
        $builder = $this->createQueryBuilder('g');
        $query = $builder->select('count(g.id)')->getQuery();

        return (int)$query->getSingleScalarResult();
    }

    public function getPaginated(?string $genreTitle, int $limit, int $offset): array
    {
        $builder = $this->createQueryBuilder('g');

        if (!empty($gemreTitle)) {
            $builder->where('g.title LIKE :title');
            $builder->setParameter('title', '%' . $gemreTitle . '%');
        }

        $builder
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        $query = $builder->getQuery();

        return $query->getResult();
    }

    /**
     * @param GenreId[] $ids
     * @return Genre[]
     */
    public function getManyById(array $ids): array
    {
        return $this->findBy([
            'id' => $ids
        ]);
    }
}

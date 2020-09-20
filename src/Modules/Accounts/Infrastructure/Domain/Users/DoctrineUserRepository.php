<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Users;

use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\Accounts\Domain\Users\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid4()->toString());
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function existsWithUsername(string $username): bool
    {
        $builder = $this->createQueryBuilder('u');

        $builder->where('u.username = :username');
        $builder->setParameter('username', $username);
        $builder->select('1');
        $query = $builder->getQuery();

        return null !== $query->getOneOrNullResult();
    }

    public function existsWithEmail(string $email): bool
    {
        $builder = $this->createQueryBuilder('u');

        $builder->where('u.email = :email');
        $builder->setParameter('email', $email);
        $builder->select('1');
        $query = $builder->getQuery();

        return null !== $query->getOneOrNullResult();
    }

    public function getByEmail(string $email): ?User
    {
        $builder = $this->createQueryBuilder('u');

        $builder->where('u.email = :email');
        $builder->setParameter('email', $email);
        $query = $builder->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getById(UserId $id): ?User
    {
        return $this->find($id);
    }
}

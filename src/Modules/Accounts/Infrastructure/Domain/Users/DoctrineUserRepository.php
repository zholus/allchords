<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Users;

use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\Accounts\Domain\Users\UserRepository;
use DateTimeImmutable;
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

    public function getUserIdByToken(string $token): ?UserId
    {
        $builder = $this->createQueryBuilder('u');

        $query = $builder
            ->select('u.id')
            ->where('u.accessToken = :ACCESS_TOKEN')
            ->andWhere('u.accessTokenExpiryAt > :EXPIRY_AT')
            ->setParameter(':ACCESS_TOKEN', $token)
            ->setParameter(':EXPIRY_AT', new DateTimeImmutable())
            ->getQuery();

        $result = $query->getScalarResult();

        if (!empty($result[0]['id'])) {
            return new UserId($result[0]['id']);
        }

        return null;
    }

    public function getByRefreshToken(string $refreshToken): ?User
    {
        return $this->findOneBy([
            'refreshToken' => $refreshToken
        ]);
    }

    // todo: move to read model
    public function getPermissions(UserId $id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT
                ap.id,
                ap.name
            FROM 
                accounts_permissions ap
            JOIN 
                accounts_roles_permissions arp on ap.id = arp.permission_id
            JOIN 
                accounts_users_roles aur on arp.role_id = aur.role_id
            WHERE 
                aur.user_id = :USER_ID
        ";

        $statement = $connection->prepare($sql);

        $statement->bindValue(':USER_ID', $id->toString());

        $statement->execute();

        return $statement->fetchAllAssociative();
    }
}

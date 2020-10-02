<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Domain\Users;

use App\Modules\Comments\Domain\Users\User;
use App\Modules\Comments\Domain\Users\UserId;
use App\Modules\Comments\Domain\Users\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function getById(UserId $id): ?User
    {
        return $this->find($id);
    }

    public function getByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }
}

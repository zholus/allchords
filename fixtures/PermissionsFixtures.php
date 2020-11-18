<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\Accounts\Domain\Users\Role;
use App\Modules\Accounts\Domain\Users\RoleId;
use App\Modules\Accounts\Domain\Users\User;
use App\Modules\SongsReviews\Application\Permissions\SongsReviewsPermissions;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class PermissionsFixtures extends AbstractFixture implements DependentFixtureInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $role = $this->addRole($manager, 'Moderator');

        /** @var User $user */
        $user = $this->getReference(UsersFixtures::ACCOUNTS_USER_1);
        $user->getRoles()->add($role);

        $manager->flush();

        $this->addPermission($role, SongsReviewsPermissions::CAN_REVIEW_SONGS);
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }

    private function addRole(ObjectManager $manager, string $name): Role
    {
        $role = new Role(
            new RoleId($this->getUuid(1)),
            $name
        );

        $manager->persist($role);

        return $role;
    }

    private function addPermission(Role $role, string $permissionName)
    {
        $id = $this->getUuid(md5($permissionName));

        $sql = "
            INSERT INTO accounts_permissions (id, name)  VALUE ('{$id}', '{$permissionName}')
        ";
        $this->entityManager->getConnection()->executeStatement($sql);

        $sql = "
            INSERT INTO accounts_roles_permissions (role_id, permission_id)  VALUE ('{$role->getId()->toString()}', '{$id}') 
        ";
        $this->entityManager->getConnection()->executeStatement($sql);
    }
}

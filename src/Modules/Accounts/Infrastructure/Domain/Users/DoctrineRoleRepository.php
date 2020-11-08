<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\Users;

use App\Modules\Accounts\Domain\Users\RoleRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineRoleRepository extends ServiceEntityRepository implements RoleRepository
{

}

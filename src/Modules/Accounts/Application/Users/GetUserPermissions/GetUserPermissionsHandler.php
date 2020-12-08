<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserPermissions;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class GetUserPermissionsHandler implements QueryHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserPermissionsQuery $query): array
    {
        $userId = new UserId($query->getUserId());

        $result = [];

        foreach ($this->userRepository->getPermissions($userId) as $row) {
            $result[] = new UserPermissionDto(
                $row['name']
            );
        }

        return $result;
    }
}

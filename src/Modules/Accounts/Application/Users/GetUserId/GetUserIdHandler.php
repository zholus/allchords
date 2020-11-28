<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserId;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class GetUserIdHandler implements QueryHandler
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function __invoke(GetUserIdQuery $query): ?string
    {
        $userId = $this->users->getUserIdByToken($query->getAccessToken());

        return $userId === null
            ? null
            : $userId->toString();
    }
}

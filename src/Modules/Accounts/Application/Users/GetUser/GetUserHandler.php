<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUser;

use App\Modules\Accounts\Domain\Users\UserId;
use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

class GetUserHandler
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function __invoke(GetUserQuery $query): UserDto
    {
        $userId = new UserId($query->getUserId());

        $user = $this->users->getById($userId);

        if ($user === null) {
            throw UserNotFoundException::withId($userId);
        }

        return new UserDto(
            $user->getId()->toString(),
            $user->getUsername(),
            $user->getEmail()
        );
    }
}

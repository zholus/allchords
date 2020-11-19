<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserByToken;

use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

class GetUserByTokenHandler
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function __invoke(GetUserByTokenQuery $query): UserDto
    {
        $user = $this->users->getByToken($query->getToken());

        if ($user === null) {
            throw UserNotFoundException::withToken($query->getToken());
        }

        return new UserDto(
            $user->getId()->toString(),
            $user->getUsername(),
            $user->getEmail(),
            $user->getAccessToken(),
            $user->getRefreshToken(),
            $user->getAccessTokenExpiryAt()
        );
    }
}

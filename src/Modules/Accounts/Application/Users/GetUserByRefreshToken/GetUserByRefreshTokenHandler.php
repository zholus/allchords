<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetUserByRefreshToken;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\Users\UserDto;
use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class GetUserByRefreshTokenHandler implements QueryHandler
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function __invoke(GetUserByRefreshTokenQuery $query): UserDto
    {
        $refreshToken = $query->getRefreshToken();

        $user = $this->users->getByRefreshToken($refreshToken);

        if ($user === null) {
            throw UserNotFoundException::withRefreshToken($refreshToken);
        }

        return new UserDto(
            $user->getId()->toString(),
            $user->getUsername(),
            $user->getEmail()
        );
    }
}

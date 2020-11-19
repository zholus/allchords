<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts\Service;

use App\Modules\Accounts\Application\Contracts\UsersContract;
use App\Modules\Accounts\Application\Users\GetUserByToken\UserDto;

final class DirectCallUsersService implements UsersService
{
    private AuthService $authService;
    private UsersContract $usersContract;

    public function __construct(
        AuthService $authService,
        UsersContract $usersContract
    ) {
        $this->authService = $authService;
        $this->usersContract = $usersContract;
    }

    public function registerUser(string $username, string $email, string $password): void
    {
        $this->usersContract->registerUser($username, $email, $password);
    }

    public function signInUser(string $email, string $password): void
    {
        $this->usersContract->signInUser($email, $password);

        $token = $this->usersContract->getToken($email);

        $user = $this->usersContract->getUserByToken($token);

        $this->authenticate($user);
    }

    public function generateNewToken(string $refreshToken): void
    {
        $this->usersContract->generateNewToken($refreshToken);
    }

    public function getTokenByEmail(string $email): string
    {
        return $this->usersContract->getToken($email);
    }

    public function signInUserByToken(string $token): void
    {
        $user = $this->usersContract->getUserByToken($token);

        $this->authenticate($user);
    }

    private function authenticate(UserDto $user): void
    {
        $this->authService->authenticate(
            $user->getUserId(),
            $user->getUsername(),
            $user->getEmail(),
            $user->getAccessToken(),
            $user->getRefreshToken(),
            $user->getAccessTokenExpiryAt()
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts\Service;

use App\Modules\Accounts\Application\Contracts\UsersContract;

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

        $user = $this->usersContract->getUserByToken($token->getToken());

        $this->authService->authenticate(
            $user->getUserId(),
            $user->getUsername(),
            $user->getEmail(),
            $token->getToken()
        );
    }
}

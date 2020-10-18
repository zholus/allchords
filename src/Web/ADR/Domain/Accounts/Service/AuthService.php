<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts\Service;

use App\Web\ADR\Domain\Accounts\User;
use App\Web\ADR\Domain\Accounts\UserUnauthorizedException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthService
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function authenticate(string $userId, string $username, string $email, string $token): void
    {
        $this->session->set('user', new User($userId, $username, $email, $token));
    }

    public function isAuthenticated(): bool
    {
        return $this->session->get('user') !== null;
    }

    public function getUserFromSession(): User
    {
        $user = $this->session->get('user');

        if ($user === null) {
            throw new UserUnauthorizedException('Unauthorized');
        }

        return $user;
    }

    public function logout(): void
    {
        $this->session->remove('user');
    }
}

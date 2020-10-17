<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts\Service;

use App\Modules\Accounts\Application\Users\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\Users\GetToken\TokenDto;
use App\Modules\Accounts\Application\Users\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\Users\GetUserByToken\UserDto;
use App\Modules\Accounts\Application\Users\RegisterUser\RegisterUserCommand;
use App\Modules\Accounts\Application\Users\SignInUser\SignInUserCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallUsersService implements UsersService
{
    private MessageBusInterface $bus;
    private AuthService $authService;

    public function __construct(MessageBusInterface $bus, AuthService $authService)
    {
        $this->bus = $bus;
        $this->authService = $authService;
    }

    public function registerUser(string $username, string $email, string $password): void
    {
        $this->bus->dispatch(new RegisterUserCommand($username, $email, $password));
    }

    public function signInUser(string $email, string $password): void
    {
        $this->bus->dispatch(new SignInUserCommand($email, $password));

        /** @var TokenDto $token */
        $token = $this->bus->dispatch(new GetTokenQuery($email))
            ->last(HandledStamp::class)
            ->getResult();

        /** @var UserDto $user */
        $user = $this->bus->dispatch(new GetUserByTokenQuery($token->getToken()))
            ->last(HandledStamp::class)
            ->getResult();

        $this->authService->addToSession(
            $user->getUserId(),
            $user->getUsername(),
            $user->getEmail(),
            $token->getToken()
        );
    }
}

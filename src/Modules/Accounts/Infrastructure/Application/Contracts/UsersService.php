<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Application\Contracts;

use App\Modules\Accounts\Application\Contracts\UsersContract;
use App\Modules\Accounts\Application\Users\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\Users\GetToken\TokenDto;
use App\Modules\Accounts\Application\Users\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\Users\GetUserByToken\UserDto;
use App\Modules\Accounts\Application\Users\RegisterUser\RegisterUserCommand;
use App\Modules\Accounts\Application\Users\SignInUser\SignInUserCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class UsersService implements UsersContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function registerUser(string $username, string $email, string $password): void
    {
        $this->bus->dispatch(new RegisterUserCommand($username, $email, $password));
    }

    public function signInUser(string $email, string $password): void
    {
        $this->bus->dispatch(new SignInUserCommand($email, $password));
    }

    public function getToken(string $email): TokenDto
    {
        return $this->bus->dispatch(new GetTokenQuery($email))
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function getUserByToken(string $token): UserDto
    {
        return $this->bus->dispatch(new GetUserByTokenQuery($token))
            ->last(HandledStamp::class)
            ->getResult();
    }
}

<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\Accounts\Service;

use App\Modules\Accounts\Application\Users\RegisterUser\RegisterUserCommand;
use Symfony\Component\Messenger\MessageBusInterface;

final class DirectCallUsersService implements UsersService
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
}

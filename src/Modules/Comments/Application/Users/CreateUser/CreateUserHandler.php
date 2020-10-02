<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Users\CreateUser;

use App\Modules\Comments\Domain\Users\User;
use App\Modules\Comments\Domain\Users\UserAlreadyExistsException;
use App\Modules\Comments\Domain\Users\UserId;
use App\Modules\Comments\Domain\Users\UserRepository;

class CreateUserHandler
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $userId = new UserId($command->getUserId());
        $username = $command->getUsername();

        if ($this->users->getById($userId) !== null) {
            throw UserAlreadyExistsException::withId($userId);
        }

        if ($this->users->getByUsername($username) !== null) {
            throw UserAlreadyExistsException::withUsername($username);
        }

        $user = new User(
            $userId,
            $username
        );

        $this->users->add($user);
    }
}

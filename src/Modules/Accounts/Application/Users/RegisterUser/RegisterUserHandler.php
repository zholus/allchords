<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\RegisterUser;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\Users\PasswordManager;
use App\Modules\Accounts\Domain\Users\User;
use App\Modules\Accounts\Domain\Users\UserAlreadyExistsException;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class RegisterUserHandler implements CommandHandler
{
    private UserRepository $userRepository;
    private PasswordManager $passwordManager;

    public function __construct(UserRepository $userRepository, PasswordManager $passwordManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordManager = $passwordManager;
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        if ($this->userRepository->existsWithUsername($command->getUsername())) {
            throw UserAlreadyExistsException::withUsername($command->getUsername());
        }

        if ($this->userRepository->existsWithEmail($command->getEmail())) {
            throw UserAlreadyExistsException::withEmail($command->getEmail());
        }

        $user = User::register(
            $this->userRepository->nextIdentity(),
            $command->getUsername(),
            $command->getEmail(),
            $this->passwordManager->hash($command->getPassword()),
        );

        $this->userRepository->add($user);
    }
}

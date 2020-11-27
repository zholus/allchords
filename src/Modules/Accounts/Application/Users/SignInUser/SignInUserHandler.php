<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\SignInUser;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\Users\PasswordManager;
use App\Modules\Accounts\Domain\Users\AccessTokenGenerator;
use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class SignInUserHandler implements CommandHandler
{
    private UserRepository $userRepository;
    private PasswordManager $passwordManager;
    private AccessTokenGenerator $accessTokenGenerator;

    public function __construct(
        UserRepository $userRepository,
        PasswordManager $passwordManager,
        AccessTokenGenerator $accessTokenGenerator
    ) {
        $this->userRepository = $userRepository;
        $this->passwordManager = $passwordManager;
        $this->accessTokenGenerator = $accessTokenGenerator;
    }

    public function __invoke(SignInUserCommand $command): void
    {
        $user = $this->userRepository->getByEmail($command->getEmail());

        if ($user === null) {
            throw UserNotFoundException::withGivenCredentials();
        }

        if (!$this->passwordManager->isValid($command->getPassword(), $user->getPassword())) {
            throw UserNotFoundException::withGivenCredentials();
        }

        $user->signIn($this->accessTokenGenerator);

        $this->userRepository->add($user);
    }
}

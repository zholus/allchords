<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GenerateNewToken;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\Users\AccessTokenGenerator;
use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class GenerateNewTokenHandler implements CommandHandler
{
    private UserRepository $users;
    private AccessTokenGenerator $tokenGenerator;

    public function __construct(UserRepository $users, AccessTokenGenerator $tokenGenerator)
    {
        $this->users = $users;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(GenerateNewTokenCommand $command): void
    {
        $refreshToken = $command->getRefreshToken();

        $user = $this->users->getByRefreshToken($refreshToken);

        if ($user === null) {
            throw UserNotFoundException::withRefreshToken($refreshToken);
        }

        $user->regenerateToken($this->tokenGenerator);
    }
}

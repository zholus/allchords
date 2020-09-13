<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetToken;

use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

class GetTokenHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetTokenCommand $command)
    {
        $user = $this->userRepository->getByEmail($command->getEmail());

        if ($user === null) {
            throw UserNotFoundException::withGivenCredentials();
        }

        return new TokenDto(
            $user->getAccessToken(),
            $user->getAccessTokenExpiryAt(),
        );
    }
}

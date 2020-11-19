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

    public function __invoke(GetTokenQuery $query): string
    {
        $user = $this->userRepository->getByEmail($query->getEmail());

        if ($user === null) {
            throw UserNotFoundException::withGivenCredentials();
        }

        return $user->getAccessToken();
    }
}

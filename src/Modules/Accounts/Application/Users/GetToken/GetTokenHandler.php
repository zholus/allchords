<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetToken;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Domain\Users\UserNotFoundException;
use App\Modules\Accounts\Domain\Users\UserRepository;

final class GetTokenHandler implements QueryHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetTokenQuery $query): TokenDto
    {
        $user = $this->userRepository->getByEmail($query->getEmail());

        if ($user === null) {
            throw UserNotFoundException::withGivenCredentials();
        }

        return new TokenDto(
            $user->getAccessToken(),
            $user->getRefreshToken(),
            $user->getAccessTokenExpiryAt()
        );
    }
}

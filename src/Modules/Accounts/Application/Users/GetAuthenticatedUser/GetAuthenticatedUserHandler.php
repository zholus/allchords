<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetAuthenticatedUser;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Query\QueryHandler;

final class GetAuthenticatedUserHandler implements QueryHandler
{
    private AuthenticatedUserContext $authenticatedUserContext;

    public function __construct(AuthenticatedUserContext $authenticatedUserContext)
    {
        $this->authenticatedUserContext = $authenticatedUserContext;
    }

    public function __invoke(GetAuthenticatedUserQuery $query)
    {
        $userId = $this->authenticatedUserContext->getUserId();

        // todo:
    }
}

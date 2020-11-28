<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\Users\GetAuthenticatedUser;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Query\QueryHandler;

final class GetAuthenticatedUserHandler /*mplements QueryHandler*/
{
    /*private AuthenticatedUserContext $authenticatedUserContext;*/

    public function __construct(/*uthenticatedUserContext $authenticatedUserContext*/)
    {
        /*$this->authenticatedUserContext = $authenticatedUserContext;*/
    }

    /*public function __invoke(GetAuthenticatedUserQuery $query)
    {
        $userId = $this->authenticatedUserContext->getUserId();

        // todo:
    }*/
}

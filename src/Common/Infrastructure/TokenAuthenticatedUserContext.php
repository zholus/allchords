<?php
declare(strict_types=1);

namespace App\Common\Infrastructure;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GetUserId\GetUserIdQuery;
use Symfony\Component\HttpFoundation\RequestStack;

final class TokenAuthenticatedUserContext implements AuthenticatedUserContext
{
    private RequestStack $requestStack;
    private QueryBus $queryBus;

    public function __construct(RequestStack $requestStack, QueryBus $queryBus)
    {
        $this->requestStack = $requestStack;
        $this->queryBus = $queryBus;
    }

    public function getUserId(): string
    {
        $request = $this->requestStack->getMasterRequest();

        $token = $request->headers->get('Authorization');

        $accessToken = explode(' ', $token)[1] ?? '';

        return $this->queryBus->handle(new GetUserIdQuery($accessToken));
    }
}

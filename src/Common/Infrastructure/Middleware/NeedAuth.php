<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Middleware;

use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GetUserId\GetUserIdQuery;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zholus\SymfonyMiddleware\MiddlewareInterface;

final class NeedAuth implements MiddlewareInterface
{
    private QueryBus $queryBus;
    private Connection $connection;

    public function __construct(QueryBus $queryBus, Connection $connection)
    {
        $this->queryBus = $queryBus;
        $this->connection = $connection;
    }

    public function handle(Request $request): ?Response
    {
        $token = $request->headers->get('Authorization');

        if ($token === null) {
            return new JsonResponse([
                'error' => 'Unauthorized. Access token needed.'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $accessToken = explode(' ', $token)[1] ?? '';

        $userId = $this->queryBus->handle(new GetUserIdQuery($accessToken));

        if ($userId === null) {
            return new JsonResponse([
                'error' => 'Unauthorized. Invalid access token.'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return null;
    }
}

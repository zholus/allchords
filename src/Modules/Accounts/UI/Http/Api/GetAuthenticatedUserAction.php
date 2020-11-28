<?php
declare(strict_types=1);

namespace App\Modules\Accounts\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GetAuthenticatedUser\GetAuthenticatedUserQuery;
use App\Modules\Accounts\Application\Users\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\Users\GetUserByToken\UserDto;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Accounts")
 */
final class GetAuthenticatedUserAction extends Action
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @OA\Parameter(
     *     name="user_id",
     *     in="path",
     *     description="Uuid user id",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="User data",
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid input request data",
     * )
     * @OA\Response(
     *     response=422,
     *     description="Cannot process request due to invalid logic",
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $userId = $request->get('user_id');

        try {
            Assert::lazy()
                ->that($userId, 'user_id')->uuid()
                ->verifyNow();

            /**
             * @var UserDto $userDto
             */
            //$userDto = $this->queryBus->handle(new GetAuthenticatedUserQuery());
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'data' => [
                'userId' => $userDto->getUserId(),
                'username' => $userDto->getUsername(),
                'email' => $userDto->getEmail(),
            ]
        ]);
    }
}
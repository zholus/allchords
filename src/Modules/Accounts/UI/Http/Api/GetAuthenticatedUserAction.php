<?php
declare(strict_types=1);

namespace App\Modules\Accounts\UI\Http\Api;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GetUser\GetUserQuery;
use App\Modules\Accounts\Application\Users\UserDto;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Accounts")
 */
final class GetAuthenticatedUserAction extends Action
{
    private QueryBus $queryBus;
    private AuthenticatedUserContext $authenticatedUserContext;

    public function __construct(AuthenticatedUserContext $authenticatedUserContext, QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        $this->authenticatedUserContext = $authenticatedUserContext;
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="User data",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="user",
     *             type="object",
     *             @OA\Property(property="user_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *             @OA\Property(property="username", type="string", example="batman"),
     *             @OA\Property(property="email", type="string", example="example@example.com"),
     *         ),
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid input request data",
     * )
     * @OA\Response(
     *     response=422,
     *     description="Cannot process request due to invalid logic",
     * ),
     * @Security(name="Bearer")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $userId = $this->authenticatedUserContext->getUserId();

        try {
            /**
             * @var UserDto $userDto
             */
            $userDto = $this->queryBus->handle(new GetUserQuery($userId));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'user' => [
                'user_id' => $userDto->getUserId(),
                'username' => $userDto->getUsername(),
                'email' => $userDto->getEmail(),
            ]
        ]);
    }
}

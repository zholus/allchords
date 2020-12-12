<?php
declare(strict_types=1);

namespace App\Modules\Accounts\UI\Http\Api;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GetUserPermissions\GetUserPermissionsQuery;
use App\Modules\Accounts\Application\Users\GetUserPermissions\UserPermissionDto;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Accounts")
 */
final class GetAuthenticatedUserPermissionsAction extends Action
{
    private QueryBus $queryBus;
    private AuthenticatedUserContext $authenticatedUserContext;

    public function __construct(QueryBus $queryBus, AuthenticatedUserContext $authenticatedUserContext)
    {
        $this->queryBus = $queryBus;
        $this->authenticatedUserContext = $authenticatedUserContext;
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Permissions list",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="permissions",
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 example="SOME_PERMISSION_NAME"
     *             )
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
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** @var UserPermissionDto[] $userPermissions */
            $userPermissions = $this->queryBus->handle(
                new GetUserPermissionsQuery($this->authenticatedUserContext->getUserId())
            );
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse($this->present($userPermissions));
    }

    private function present(array $userPermissions): array
    {
        return [
            'permissions' => array_map(
                fn(UserPermissionDto $permissionDto) => $permissionDto->getName(),
                $userPermissions
            )
        ];
    }
}

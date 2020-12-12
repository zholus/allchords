<?php
declare(strict_types=1);

namespace App\Modules\Accounts\UI\Http\Api;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GenerateNewToken\GenerateNewTokenCommand;
use App\Modules\Accounts\Application\Users\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\Users\GetToken\TokenDto;
use App\Modules\Accounts\Application\Users\GetUserByRefreshToken\GetUserByRefreshTokenQuery;
use App\Modules\Accounts\Application\Users\UserDto;
use Assert\Assert;
use DateTime;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Accounts")
 */
final class RefreshAccessToken extends Action
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="refresh_token",
     *                    type="string",
     *                    example="",
     *                    description=""
     *                ),
     *          ),
     *     ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Access token",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="access_token", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *         @OA\Property(property="expire_at", type="string", example="2020-12-12T02:59:30+0000"),
     *         @OA\Property(property="refresh_token", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
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
        $refreshToken = $request->get('refresh_token');

        try {
            Assert::lazy()
                ->that($refreshToken, 'refresh_token')->uuid()
                ->verifyNow();

            /** @var UserDto $userDto */
            $userDto = $this->queryBus->handle(new GetUserByRefreshTokenQuery($refreshToken));

            $this->commandBus->dispatch(new GenerateNewTokenCommand($refreshToken));

            /** @var TokenDto $tokenDto */
            $tokenDto = $this->queryBus->handle(new GetTokenQuery($userDto->getEmail()));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'access_token' => $tokenDto->getToken(),
            'expire_at' => $tokenDto->getExpiryAt()->format(DateTime::ISO8601),
            'refresh_token' => $tokenDto->getRefreshToken(),
        ]);
    }
}

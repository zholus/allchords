<?php
declare(strict_types=1);

namespace App\Modules\Accounts\UI\Http\Api;

use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\Users\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\Users\GetToken\TokenDto;
use App\Modules\Accounts\Application\Users\SignInUser\SignInUserCommand;
use Assert\Assert;
use DateTimeImmutable;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Accounts")
 */
final class SignInUserAction extends Action
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
     *              @OA\Property(property="email",
     *                    type="string",
     *                    example="",
     *                    description=""
     *                ),
     *    			@OA\Property(property="password",
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
        $email = $request->get('email');
        $password = $request->get('password');

        try {
            Assert::lazy()
                ->that($email, 'email')->email()
                ->that($password, 'password')->notEmpty()
                ->verifyNow();

            $this->commandBus->dispatch(new SignInUserCommand(
                $email,
                $password
            ));

            /**
             * @var TokenDto $tokenDto
             */
            $tokenDto = $this->queryBus->handle(new GetTokenQuery($email));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'access_token' => $tokenDto->getToken(),
            'expire_at' => $tokenDto->getExpiryAt()->format(DateTimeImmutable::RFC3339),
            'refresh_token' => $tokenDto->getRefreshToken(),
        ]);
    }
}
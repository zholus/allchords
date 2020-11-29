<?php
declare(strict_types=1);

namespace App\Modules\Accounts\UI\Http\Api;

use App\Common\Application\Command\CommandBus;
use App\Modules\Accounts\Application\Users\RegisterUser\RegisterUserCommand;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

/**
 * @OA\Tag(name="Accounts")
 */
final class RegisterUserAction extends Action
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="email",
     *    			    type="string",
     *    				example="",
     *    				description=""
     *    			),
     *    			@OA\Property(property="username",
     *    				type="string",
     *    				example="",
     *    				description=""
     *    			),
     *    			@OA\Property(property="password",
     *    			    type="string",
     *    			    example="",
     *    			    description=""
     *    	       ),
     *          ),
     *     ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Register user",
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
        $username = $request->get('username');
        $password = $request->get('password');

        try {
            Assert::lazy()
                ->that($email, 'email')->email()
                ->that($username, 'username')->notEmpty()
                ->that($password, 'password')->notEmpty()
                ->verifyNow();

            $this->commandBus->dispatch(new RegisterUserCommand(
                $username,
                $email,
                $password
            ));
        } catch (Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'message' => 'success'
        ], JsonResponse::HTTP_CREATED);
    }
}

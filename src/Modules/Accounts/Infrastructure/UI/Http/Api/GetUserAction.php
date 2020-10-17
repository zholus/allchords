<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Api;

use App\Modules\Accounts\Application\Users\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\Users\GetUserByToken\UserDto;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @OA\Tag(name="Accounts")
 */
final class GetUserAction extends Action
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
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
            $userDto = $this->bus->dispatch(new GetUserByTokenQuery($userId))
                ->last(HandledStamp::class)
                ->getResult();
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'data' => $userDto->toArray()
        ]);
    }
}

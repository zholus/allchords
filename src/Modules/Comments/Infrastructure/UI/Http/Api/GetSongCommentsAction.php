<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\UI\Http\Api;

use App\Modules\Comments\Application\Songs\GetComment\CommentDto;
use App\Modules\Comments\Application\Songs\GetComments\GetCommentsQuery;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @OA\Tag(name="Comments")
 */
class GetSongCommentsAction extends Action
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @OA\Parameter(
     *     name="song_id",
     *     in="path",
     *     description="Uuid song id",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Songs comments",
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
        $songId = $request->get('song_id', '');
        $page = (int)$request->get('page', 1);
        $perPage = (int)$request->get('per_page', 50);

        try {
            Assert::lazy()
                ->that($songId, 'song_id')->uuid()
                ->that($page, 'page')->notEmpty()->integer()
                ->that($perPage, 'per_page')->notEmpty()->integer()
                ->verifyNow();

            /** @var CommentDto $commentsDto */
            $commentsDto = $this->bus->dispatch(new GetCommentsQuery($songId, $page, $perPage))
                ->last(HandledStamp::class)
                ->getResult();
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'data' => $commentsDto->toArray()
        ]);
    }
}

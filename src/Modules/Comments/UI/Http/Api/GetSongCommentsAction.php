<?php
declare(strict_types=1);

namespace App\Modules\Comments\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\Comments\Application\Songs\GetComments\CommentsDto;
use App\Modules\Comments\Application\Songs\GetComments\GetCommentsQuery;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Comments")
 */
class GetSongCommentsAction extends Action
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
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

            /** @var CommentsDto $commentsDto */
            $commentsDto = $this->queryBus->handle(new GetCommentsQuery($songId, $page, $perPage));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'data' => $commentsDto->toArray()
        ], 200, [
            'x-pagination-current-page' => $commentsDto->getPagination()->getCurrentPage(),
            'x-pagination-elements-on-page' => $commentsDto->getPagination()->getElementsOnPage(),
            'x-pagination-total-elements-count' => $commentsDto->getPagination()->getTotalElementsCount(),
            'x-pagination-total-pages-count' => $commentsDto->getPagination()->getTotalPagesCount(),
        ]);
    }
}

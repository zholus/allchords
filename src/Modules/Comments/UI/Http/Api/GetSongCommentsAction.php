<?php
declare(strict_types=1);

namespace App\Modules\Comments\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\Comments\Application\Songs\GetComments\CommentDto;
use App\Modules\Comments\Application\Songs\GetComments\CommentsCollection;
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
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Number of page",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     description="Comments per page",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Song comments",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="song_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *         @OA\Property(
     *             property="comments",
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="comment_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *                  @OA\Property(property="author_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *                  @OA\Property(property="author_username", type="string", example="batman"),
     *                  @OA\Property(property="text", type="string", example="comment text"),
     *                  @OA\Property(property="created_at", type="string", example="2020-12-12T02:59:30+0000"),
     *              )
     *         ),
     *         @OA\Property(
     *             property="pagination",
     *             type="object",
     *             @OA\Property(property="elements_on_page", type="number", example="5"),
     *             @OA\Property(property="total_pages_count", type="number", example="2"),
     *             @OA\Property(property="current_page", type="number", example="1"),
     *             @OA\Property(property="total_elements_count", type="number", example="10"),
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
        $songId = $request->get('song_id', '');
        $page = (int)$request->get('page', 1);
        $perPage = (int)$request->get('per_page', 50);

        try {
            Assert::lazy()
                ->that($songId, 'song_id')->uuid()
                ->that($page, 'page')->notEmpty()->integer()
                ->that($perPage, 'per_page')->notEmpty()->integer()
                ->verifyNow();

            /** @var CommentsCollection $commentsCollection */
            $commentsCollection = $this->queryBus->handle(new GetCommentsQuery($songId, $page, $perPage));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse($this->present($commentsCollection));
    }

    private function present(CommentsCollection $commentsCollection): array
    {
        $comments = [];

        foreach ($commentsCollection->getComments() as $commentDto) {
            $comments[] = [
                'comment_id' => $commentDto->getCommentId(),
                'author_id' => $commentDto->getAuthorId(),
                'author_username' => $commentDto->getAuthorUsername(),
                'text' => $commentDto->getText(),
                'created_at' => $commentDto->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return [
            'song_id' => $commentsCollection->getSongId(),
            'comments' => $comments,
            'pagination' => [
                'elements_on_page' => $commentsCollection->getPaginationDto()->getElementsOnPage(),
                'total_pages_count' => $commentsCollection->getPaginationDto()->getTotalPagesCount(),
                'current_page' => $commentsCollection->getPaginationDto()->getCurrentPage(),
                'total_elements_count' => $commentsCollection->getPaginationDto()->getTotalElementsCount(),
            ]
        ];
    }
}

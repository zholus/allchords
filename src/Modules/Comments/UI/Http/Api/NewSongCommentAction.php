<?php
declare(strict_types=1);

namespace App\Modules\Comments\UI\Http\Api;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Modules\Comments\Application\Songs\CreateNewComment\CreateNewSongCommentCommand;
use App\Modules\Comments\Application\Songs\GetLastAuthorCommentComment\CommentDto;
use App\Modules\Comments\Application\Songs\GetLastAuthorCommentComment\GetLastAuthorCommentCommentQuery;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Tag(name="Comments")
 */
final class NewSongCommentAction extends Action
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private AuthenticatedUserContext $authenticatedUserContext;

    public function __construct(
        AuthenticatedUserContext $authenticatedUserContext,
        CommandBus $commandBus,
        QueryBus $queryBus
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->authenticatedUserContext = $authenticatedUserContext;
    }

    /**
     * @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *    			@OA\Property(property="song_id",
     *    				type="string",
     *    				example="",
     *    				description=""
     *    			),
     *    			@OA\Property(property="text",
     *    			    type="string",
     *    			    example="",
     *    			    description=""
     *    	       ),
     *          ),
     *     ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Comment added",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="comment",
     *             type="object",
     *             @OA\Property(property="comment_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *             @OA\Property(property="author_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *             @OA\Property(property="author_username", type="string", example="batman"),
     *             @OA\Property(property="text", type="string", example="comment text"),
     *             @OA\Property(property="created_at", type="string", example="2020-12-12T02:59:30+0000"),
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
        $authorId = $this->authenticatedUserContext->getUserId();
        $songId = $request->get('song_id', '');
        $text = $request->get('text', '');

        try {
            Assert::lazy()
                ->that($songId, 'song_id')->uuid()
                ->that($text, 'text')->string()->notEmpty()
                ->verifyNow();

            $this->commandBus->dispatch(new CreateNewSongCommentCommand(
                $authorId,
                $songId,
                $text,
            ));

            /**
             * @var CommentDto $commentDto
             */
            $commentDto = $this->queryBus->handle(new GetLastAuthorCommentCommentQuery($authorId));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse($this->present($commentDto), JsonResponse::HTTP_CREATED);
    }

    private function present(CommentDto $commentDto): array
    {
        return [
            'comment' => [
                'comment_id' => $commentDto->getCommentId(),
                'author_id' => $commentDto->getAuthorId(),
                'author_username' => $commentDto->getAuthorUsername(),
                'text' => $commentDto->getText(),
                'created_at' => $commentDto->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        ];
    }
}

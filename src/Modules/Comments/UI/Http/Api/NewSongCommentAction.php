<?php
declare(strict_types=1);

namespace App\Modules\Comments\UI\Http\Api;

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
     *              @OA\Property(property="author_id",
     *    			    type="string",
     *    				example="",
     *    				description=""
     *    			),
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
     *     response=200,
     *     description="Comment added",
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
        $authorId = $request->get('author_id', '');
        $songId = $request->get('song_id', '');
        $text = $request->get('text', '');

        try {
            Assert::lazy()
                ->that($authorId, 'author_id')->uuid()
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

        return new JsonResponse([
            'data' => $commentDto->toArray()
        ]);
    }
}

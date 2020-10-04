<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\UI\Http\Api;

use App\Modules\Comments\Application\Songs\GetComments\CommentDto;
use App\Modules\Comments\Application\Songs\CreateNewComment\CreateNewSongCommentCommand;
use App\Modules\Comments\Application\Songs\GetComment\GetCommentQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSong\GetSongQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSong\SongDto;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @OA\Tag(name="Comments")
 */
final class NewSongCommentAction extends Action
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
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

            $commentId = $this->bus->dispatch(new CreateNewSongCommentCommand(
                $authorId,
                $songId,
                $text,
            ))->last(HandledStamp::class)->getResult();

            /**
             * @var CommentDto $commentDto
             */
            $commentDto = $this->bus
                ->dispatch(new GetCommentQuery($commentId))
                ->last(HandledStamp::class)
                ->getResult();
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'data' => $commentDto->toArray()
        ]);
    }
}

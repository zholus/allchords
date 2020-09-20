<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\UI\Http\Api;

use App\Modules\SongsCatalog\Application\Songs\CreateNew\NewSongCommand;
use App\Modules\SongsCatalog\Application\Songs\GetSong\GetSongQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSong\SongDto;
use Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @OA\Tag(name="Songs")
 */
final class NewSongAction extends Action
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
     *    			@OA\Property(property="creator_id",
     *    				type="string",
     *    				example="",
     *    				description=""
     *    			),
     *    			@OA\Property(property="genre_id",
     *    			    type="string",
     *    			    example="",
     *    			    description=""
     *    	       ),
     *    			@OA\Property(property="title",
     *    			    type="string",
     *    			    example="",
     *    			    description=""
     *    	       ),
     *    			@OA\Property(property="chords",
     *    			    type="string",
     *    			    example="",
     *    			    description=""
     *    	       ),
     *          ),
     *     ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Songs created",
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
        $creatorId = $request->get('creator_id', '');
        $genreId = $request->get('genre_id', '');
        $title = $request->get('title', '');
        $chords = $request->get('chords', '');

        try {
            Assert::lazy()
                ->that($authorId, 'author')->string()->notEmpty()
                ->that($creatorId, 'creator')->string()->notEmpty()
                ->that($genreId, 'genre')->string()->notEmpty()
                ->that($title, 'title')->string()->notEmpty()
                ->that($chords, 'chords')->string()->notEmpty()
                ->verifyNow();

            $songId = $this->bus->dispatch(new NewSongCommand(
                $authorId,
                $creatorId,
                $genreId,
                $title,
                $chords
            ))->last(HandledStamp::class)->getResult();

            /**
             * @var SongDto $songDto
             */
            $songDto = $this->bus
                ->dispatch(new GetSongQuery($songId))
                ->last(HandledStamp::class)
                ->getResult();
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([
            'data' => $songDto->toArray()
        ]);
    }
}

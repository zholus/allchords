<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\UI\Http\Api;

use App\Common\Application\AuthenticatedUserContext;
use App\Common\Application\Command\CommandBus;
use App\Modules\SongsReviews\Application\Reviews\NewReview\NewReviewCommand;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(name="SongsReviews")
 */
final class NewReviewAction extends Action
{
    private CommandBus $commandBus;
    private AuthenticatedUserContext $authenticatedUserContext;

    public function __construct(CommandBus $commandBus, AuthenticatedUserContext $authenticatedUserContext)
    {
        $this->commandBus = $commandBus;
        $this->authenticatedUserContext = $authenticatedUserContext;
    }

    /**
     * @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="title",
     *    			    type="string",
     *    				example="",
     *    				description=""
     *    			),
     *    			@OA\Property(property="artists_ids",
     *    				type="array",
     *    				example="",
     *    				description="",
     *                  @OA\Items(
     *                      type="string"
     *                  )
     *    			),
     *    			@OA\Property(property="genres_ids",
     *    			    type="array",
     *    			    example="",
     *    			    description="",
     *                  @OA\Items(
     *                      type="string"
     *                  )
     *    	        ),
     *              @OA\Property(property="chords",
     *    			    type="string",
     *    				example="",
     *    				description=""
     *    			),
     *          ),
     *     ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Review created",
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
    public function __invoke(Request $request): Response
    {
        $title = $request->get('title');
        $artistsIds = $request->get('artists_ids');
        $genresIds = $request->get('genres_ids');
        $chords = $request->get('chords');

        try {
            Assert::lazy()
                ->that($title, 'title')->string()->notEmpty()
                ->that($artistsIds, 'artists_ids')->notEmpty()->isArray()
                ->that($genresIds, 'genres_ids')->notEmpty()->isArray()
                ->that($chords, 'chords')->notEmpty()
                ->verifyNow();

            $this->commandBus->dispatch(new NewReviewCommand(
                $this->authenticatedUserContext->getUserId(),
                $artistsIds,
                $genresIds,
                $title,
                $chords
            ));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}

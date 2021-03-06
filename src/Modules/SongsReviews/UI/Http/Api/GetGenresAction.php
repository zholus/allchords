<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GenresPaginatedCollection;
use App\Modules\SongsReviews\Application\Genres\GetGenresPaginated\GetGenresPaginatedQuery;
use Assert\Assert;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(name="SongsReviews")
 */
final class GetGenresAction extends Action
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @OA\Parameter(
     *     name="genre_title",
     *     in="query",
     *     description="Genre title",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Limit of genres on single page. Default 5",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page number",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Genres list",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="genres",
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="genre_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *                  @OA\Property(property="genre_title", type="string", example="rock"),
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
     * ),
     * @Security(name="Bearer")
     */
    public function __invoke(Request $request): Response
    {
        $genreTitle = $request->get('genre_title');
        $limit = (int)$request->get('limit', 5);
        $page = (int)$request->get('page', 1);

        try {
            Assert::lazy()
                ->that($genreTitle, 'genre_title')->nullOr()->string()
                ->that($limit, 'limit')->integer()->greaterThan(0)
                ->that($page, 'page')->integer()->greaterThan(0)
                ->verifyNow();

            $genres = $this->queryBus->handle(new GetGenresPaginatedQuery($genreTitle, $limit, $page));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse($this->present($genres));
    }

    private function present(GenresPaginatedCollection $genresCollection)
    {
        $genres = [];

        foreach ($genresCollection->getGenresDto() as $genreDto) {
            $genres[] = [
                'genre_id' => $genreDto->getId(),
                'genre_title' => $genreDto->getTitle(),
            ];
        }

        return [
            'genres' => $genres,
            'pagination' => [
                'elements_on_page' => $genresCollection->getPaginationDto()->getElementsOnPage(),
                'total_pages_count' => $genresCollection->getPaginationDto()->getTotalPagesCount(),
                'current_page' => $genresCollection->getPaginationDto()->getCurrentPage(),
                'total_elements_count' => $genresCollection->getPaginationDto()->getTotalElementsCount(),
            ]
        ];
    }
}

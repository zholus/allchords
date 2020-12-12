<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\SongsCatalog\Application\Songs\GetSongs\GetSongsQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSongs\SongsCollection;
use Assert\Assert;
use DateTime;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(name="SongsCatalog")
 */
final class GetSongsAction extends Action
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Limit of songs. Default 3",
     *     @OA\Schema(type="integer")
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
     *     description="Songs per page",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="creation_date",
     *     in="query",
     *     description="Date of songs creation. Format - Y-m-d",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Songs list",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="songs",
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="song_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *                  @OA\Property(property="title", type="string", example="tnt"),
     *                  @OA\Property(property="artist_id", type="string", example="404f5d14-6d54-4759-aa5d-944ac70abd07"),
     *                  @OA\Property(property="artist_name", type="string", example="ac/dc"),
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
    public function __invoke(Request $request): Response
    {
        $limit = (int)$request->get('limit', 3);
        $page = (int)$request->get('page', 1);
        $perPage = (int)$request->get('per_page', 50);
        $creationDate = $request->get('creation_date');

        try {
            Assert::lazy()
                ->that($limit, 'limit')->integer()->greaterThan(0)->notEmpty()
                ->that($page, 'page')->notEmpty()->integer()
                ->that($perPage, 'per_page')->notEmpty()->integer()
                ->that($creationDate, 'creation_date')->nullOr()->date('Y-m-d')
                ->verifyNow();

            if ($creationDate !== null) {
                $creationDate = new \DateTimeImmutable($creationDate);
            }

            /** @var SongsCollection $songs */
            $songs = $this->queryBus->handle(new GetSongsQuery($limit, $page, $perPage, $creationDate));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse($this->present($songs));
    }

    private function present(SongsCollection $songsCollection): array
    {
        $songs = [];

        foreach ($songsCollection->getSongs() as $song) {
            $songs[] = [
                'song_id' => $song->getSongId(),
                'title' => $song->getTitle(),
                'artist_id' => $song->getArtistId(),
                'artist_name' => $song->getArtistName(),
                'created_at' => $song->getCreatedAt()->format(DateTime::ISO8601),
            ];
        }

        return [
            'songs' => $songs,
            'pagination' => [
                'elements_on_page' => $songsCollection->getPaginationDto()->getElementsOnPage(),
                'total_pages_count' => $songsCollection->getPaginationDto()->getTotalPagesCount(),
                'current_page' => $songsCollection->getPaginationDto()->getCurrentPage(),
                'total_elements_count' => $songsCollection->getPaginationDto()->getTotalElementsCount(),
            ]
        ];
    }
}

<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\SongsCatalog\Application\Songs\GetSongs\GetSongsQuery;
use App\Modules\SongsCatalog\Application\Songs\GetSongs\SongsCollection;
use Assert\Assert;
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

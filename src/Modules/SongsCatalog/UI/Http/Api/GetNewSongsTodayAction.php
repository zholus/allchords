<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\UI\Http\Api;

use App\Common\Application\Query\QueryBus;
use App\Modules\SongsCatalog\Application\Songs\GetNewSongsToday\GetNewSongsTodayQuery;
use App\Modules\SongsCatalog\Application\Songs\GetNewSongsToday\SongsDto;
use Assert\Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(name="SongsCatalog")
 */
final class GetNewSongsTodayAction extends Action
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request): Response
    {
        $limit = (int)$request->get('limit', 0);

        try {
            Assert::lazy()
                ->that($limit, 'limit')->integer()->greaterThan(0)->notEmpty()
                ->verifyNow();

            /** @var SongsDto $songs */
            $songs = $this->queryBus->handle(new GetNewSongsTodayQuery($limit, new \DateTimeImmutable()));
        } catch (\Throwable $exception) {
            return $this->responseByException($exception);
        }

        return new JsonResponse($this->present($songs));
    }

    private function present(SongsDto $songs): array
    {
        $result = [];

        foreach ($songs->getSongs() as $song) {
            $result[] = [
                'song_id' => $song->getSongId(),
                'title' => $song->getTitle(),
                'artist_id' => $song->getArtistId(),
                'artist_name' => $song->getArtistName(),
            ];
        }

        return [
            'songs' => $result
        ];
    }
}

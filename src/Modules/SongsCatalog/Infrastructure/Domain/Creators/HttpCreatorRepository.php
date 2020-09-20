<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Domain\Creators;

use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Creators\CreatorRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpCreatorRepository implements CreatorRepository
{
    private HttpClientInterface $httpClient;
    private string $accountServiceUrl;

    public function __construct(HttpClientInterface $httpClient, string $accountServiceUrl)
    {
        $this->httpClient = $httpClient;
        $this->accountServiceUrl = $accountServiceUrl;
    }

    public function isCreatorExists(CreatorId $id): bool
    {
        $url = $this->buildUrl('users/' . $id->toString());

        $response = $this->httpClient->request(
            'GET',
            $url
        );

        return $response->getStatusCode() === 200;
    }

    private function buildUrl(string $path): string
    {
        return sprintf(
            '%s/%s',
            rtrim($this->accountServiceUrl, '/'),
            $path
        );
    }
}

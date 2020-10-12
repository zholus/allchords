<?php
declare(strict_types=1);

namespace App\Web\ADR\Action;

use App\Web\ADR\Domain\SongsCatalog\Service\SongsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomePageAction extends AbstractController
{
    private SongsService $songs;

    public function __construct(SongsService $songs)
    {
        $this->songs = $songs;
    }

    public function __invoke(): Response
    {
        $songs = $this->songs->getSongsByCreatedDate(3, new \DateTimeImmutable());

        return $this->render('home_page.twig', [
            'songs' => $songs
        ]);
    }
}

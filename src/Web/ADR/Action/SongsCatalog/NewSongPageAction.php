<?php
declare(strict_types=1);

namespace App\Web\ADR\Action\SongsCatalog;

use App\Web\ADR\Action\Action;
use Symfony\Component\HttpFoundation\Response;

final class NewSongPageAction extends Action
{
    public function __invoke(): Response
    {
        return $this->render('songs_catalog/song_new.twig');
    }
}

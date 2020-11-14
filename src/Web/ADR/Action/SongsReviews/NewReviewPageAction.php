<?php
declare(strict_types=1);

namespace App\Web\ADR\Action\SongsReviews;

use App\Web\ADR\Action\Action;
use Symfony\Component\HttpFoundation\Response;

final class NewReviewPageAction extends Action
{
    public function __invoke(): Response
    {
        return $this->render('songs_reviews/song_new.twig');
    }
}

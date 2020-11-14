<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Application\Contracts;

use App\Modules\SongsReviews\Application\Contracts\ReviewsContract;
use App\Modules\SongsReviews\Application\Reviews\NewReview\NewReviewCommand;
use Symfony\Component\Messenger\MessageBusInterface;

final class ReviewsService implements ReviewsContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function newReview(
        string $creatorId,
        array $artistsIds,
        array $genresIds,
        string $title,
        string $chords
    ): void {
        $this->bus->dispatch(new NewReviewCommand(
            $artistsIds,
            $creatorId,
            $genresIds,
            $title,
            $chords
        ));
    }
}

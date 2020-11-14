<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Reviews;

use App\Modules\SongsReviews\Domain\Artists\Artist;
use App\Modules\SongsReviews\Domain\Creators\Creator;
use App\Modules\SongsReviews\Domain\Genres\Genre;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class Review
{
    private ReviewId $id;
    private Collection $artists;
    private Creator $creator;
    private Collection $genres;
    private string $title;
    private string $chords;
    private DateTimeImmutable $createdAt;

    public function __construct(
        ReviewId $id,
        Collection $artists,
        Creator $creator,
        Collection $genres,
        string $title,
        string $chords,
        DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->artists = $artists;
        $this->creator = $creator;
        $this->genres = $genres;
        $this->title = $title;
        $this->chords = $chords;
        $this->createdAt = $createdAt;
    }

    public static function new(
        ReviewId $id,
        Collection $artists,
        Creator $creator,
        Collection $genres,
        string $title,
        string $chords
    ): self {
        return new self(
            $id,
            $artists,
            $creator,
            $genres,
            $title,
            $chords,
            new DateTimeImmutable()
        );
    }
}

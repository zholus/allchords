<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Reviews\NewReview;

class NewReviewCommand
{
    private array $artistsIds;
    private string $creatorId;
    private array $genresIds;
    private string $title;
    private string $chords;

    public function __construct(
        array $artistsIds,
        string $creatorId,
        array $genresIds,
        string $title,
        string $chords
    ) {
        $this->artistsIds = $artistsIds;
        $this->creatorId = $creatorId;
        $this->genresIds = $genresIds;
        $this->title = $title;
        $this->chords = $chords;
    }

    public function getArtistsIds(): array
    {
        return $this->artistsIds;
    }

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function getGenresIds(): array
    {
        return $this->genresIds;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getChords(): string
    {
        return $this->chords;
    }
}

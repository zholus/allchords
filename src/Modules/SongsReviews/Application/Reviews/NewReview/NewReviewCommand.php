<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Reviews\NewReview;

use App\Common\Application\Command\Command;

final class NewReviewCommand implements Command
{
    private array $artistsIds;
    private string $creatorId;
    private array $genresIds;
    private string $title;
    private string $chords;

    public function __construct(
        string $creatorId,
        array $artistsIds,
        array $genresIds,
        string $title,
        string $chords
    ) {
        $this->creatorId = $creatorId;
        $this->artistsIds = $artistsIds;
        $this->genresIds = $genresIds;
        $this->title = $title;
        $this->chords = $chords;
    }

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function getArtistsIds(): array
    {
        return $this->artistsIds;
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

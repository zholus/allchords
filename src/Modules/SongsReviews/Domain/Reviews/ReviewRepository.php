<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Reviews;

interface ReviewRepository
{
    public function nextIdentity(): ReviewId;
    public function add(Review $review): void;
}

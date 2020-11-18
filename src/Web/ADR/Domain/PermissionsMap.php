<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain;

use App\Modules\SongsReviews\Application\Permissions\SongsReviewsPermissions;
use App\Web\ADR\Action\SongsReviews\GetSongsForReview;

final class PermissionsMap
{
    public const MAP = [
        GetSongsForReview::class => [
            SongsReviewsPermissions::CAN_REVIEW_SONGS
        ]
    ];
}

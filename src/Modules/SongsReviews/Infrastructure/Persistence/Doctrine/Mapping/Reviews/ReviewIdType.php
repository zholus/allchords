<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Persistence\Doctrine\Mapping\Reviews;

use App\Modules\SongsReviews\Domain\Reviews\ReviewId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class ReviewIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ReviewId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->toString();
    }

    public function getName()
    {
        return self::Uuid;
    }
}

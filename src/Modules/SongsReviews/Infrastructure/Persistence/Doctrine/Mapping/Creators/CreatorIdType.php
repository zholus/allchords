<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Infrastructure\Persistence\Doctrine\Mapping\Creators;

use App\Modules\SongsReviews\Domain\Creators\CreatorId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class CreatorIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new CreatorId($value);
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
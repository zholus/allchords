<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Persistence\Doctrine\Mapping\Artists;

use App\Modules\SongsCatalog\Domain\Artists\ArtistId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class ArtistIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ArtistId($value);
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

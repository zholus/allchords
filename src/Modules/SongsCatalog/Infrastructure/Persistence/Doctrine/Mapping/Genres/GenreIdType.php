<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Infrastructure\Persistence\Doctrine\Mapping\Genres;

use App\Modules\SongsCatalog\Domain\Genres\GenreId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class GenreIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new GenreId($value);
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

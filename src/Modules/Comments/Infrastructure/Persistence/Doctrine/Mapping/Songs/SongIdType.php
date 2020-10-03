<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Persistence\Doctrine\Mapping\Songs;

use App\Modules\Comments\Domain\Songs\SongId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class SongIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new SongId($value);
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

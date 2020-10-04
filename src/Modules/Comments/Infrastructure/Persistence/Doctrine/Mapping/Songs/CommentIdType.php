<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Persistence\Doctrine\Mapping\Songs;

use App\Modules\Comments\Domain\Songs\CommentId;
use App\Modules\Comments\Domain\Songs\SongId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class CommentIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new CommentId($value);
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

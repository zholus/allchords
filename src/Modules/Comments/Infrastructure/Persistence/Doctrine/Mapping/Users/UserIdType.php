<?php
declare(strict_types=1);

namespace App\Modules\Comments\Infrastructure\Persistence\Doctrine\Mapping\Users;

use App\Modules\Comments\Domain\Users\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UserIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
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

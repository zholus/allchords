<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Doctrine\Mapping\Users;

use App\Modules\Accounts\Domain\Users\RoleId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class RoleIdType extends GuidType
{
    const Uuid = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new RoleId($value);
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

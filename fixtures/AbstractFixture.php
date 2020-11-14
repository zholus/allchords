<?php
declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Ramsey\Uuid\Uuid;

abstract class AbstractFixture extends Fixture
{
    private array $uuids = [];

    public function getUuid($index)
    {
        if (!empty($this->uuids[$index])) {
            return $this->uuids[$index];
        }

        return $this->uuids[$index] = Uuid::uuid4()->toString();
    }
}

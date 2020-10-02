<?php
declare(strict_types=1);

namespace App\Modules\SongsCatalog\Application\Creators\CreateNew;

use App\Modules\SongsCatalog\Domain\Creators\Creator;
use App\Modules\SongsCatalog\Domain\Creators\CreatorAlreadyExistsException;
use App\Modules\SongsCatalog\Domain\Creators\CreatorId;
use App\Modules\SongsCatalog\Domain\Creators\CreatorRepository;

class CreateNewCreatorHandler
{
    private CreatorRepository $creators;

    public function __construct(CreatorRepository $creators)
    {
        $this->creators = $creators;
    }

    public function __invoke(CreateNewCreatorCommand $command)
    {
        $creatorId = new CreatorId($command->getCreatorId());
        $creatorUsername = $command->getUsername();

        if ($this->creators->getById($creatorId) !== null) {
            throw CreatorAlreadyExistsException::withId($creatorId);
        }

        if ($this->creators->getByUsername($creatorUsername) !== null) {
            throw CreatorAlreadyExistsException::withUsername($creatorUsername);
        }

        $this->creators->add(
            new Creator(
                $creatorId,
                $creatorUsername
            )
        );
    }
}

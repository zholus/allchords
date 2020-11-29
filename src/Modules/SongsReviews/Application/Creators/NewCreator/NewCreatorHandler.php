<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Creators\NewCreator;

use App\Common\Application\Command\CommandHandler;
use App\Modules\SongsReviews\Domain\Creators\Creator;
use App\Modules\SongsReviews\Domain\Creators\CreatorAlreadyExistsException;
use App\Modules\SongsReviews\Domain\Creators\CreatorId;
use App\Modules\SongsReviews\Domain\Creators\CreatorRepository;

final class NewCreatorHandler implements CommandHandler
{
    private CreatorRepository $creatorRepository;

    public function __construct(CreatorRepository $creatorRepository)
    {
        $this->creatorRepository = $creatorRepository;
    }

    public function __invoke(NewCreatorCommand $command)
    {
        $creatorId = new CreatorId($command->getCreatorId());

        if (null !== $this->creatorRepository->getById($creatorId)) {
            throw CreatorAlreadyExistsException::withId($creatorId);
        }

        $this->creatorRepository->add(new Creator(
            $creatorId,
            $command->getUsername()
        ));
    }
}

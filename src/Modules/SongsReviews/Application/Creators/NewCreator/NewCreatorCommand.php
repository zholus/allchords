<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Application\Creators\NewCreator;

use App\Common\Application\Command\Command;

final class NewCreatorCommand implements Command
{
    private string $creatorId;
    private string $username;

    public function __construct(string $creatorId, string $username)
    {
        $this->creatorId = $creatorId;
        $this->username = $username;
    }

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}

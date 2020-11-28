<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Authors\CreateAuthor;

use App\Common\Application\Command\Command;

final class CreateAuthorCommand implements Command
{
    private string $authorId;
    private string $username;

    public function __construct(string $authorId, string $username)
    {
        $this->authorId = $authorId;
        $this->username = $username;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}

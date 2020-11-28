<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Authors\CreateAuthor;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Comments\Domain\Authors\Author;
use App\Modules\Comments\Domain\Authors\AuthorAlreadyExistsException;
use App\Modules\Comments\Domain\Authors\AuthorId;
use App\Modules\Comments\Domain\Authors\AuthorRepository;

final class CreateAuthorHandler implements CommandHandler
{
    private AuthorRepository $authors;

    public function __construct(AuthorRepository $authors)
    {
        $this->authors = $authors;
    }

    public function __invoke(CreateAuthorCommand $command): void
    {
        $authorId = new AuthorId($command->getAuthorId());
        $username = $command->getUsername();

        if ($this->authors->getById($authorId) !== null) {
            throw AuthorAlreadyExistsException::withId($authorId);
        }

        if ($this->authors->getByUsername($username) !== null) {
            throw AuthorAlreadyExistsException::withUsername($username);
        }

        $author = new Author(
            $authorId,
            $username
        );

        $this->authors->add($author);
    }
}

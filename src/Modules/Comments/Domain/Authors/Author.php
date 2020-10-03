<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Authors;

class Author
{
    private AuthorId $id;
    private string $username;

    public function __construct(AuthorId $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function getId(): AuthorId
    {
        return $this->id;
    }
}

<?php
declare(strict_types=1);

namespace App\Modules\SongsReviews\Domain\Creators;

class Creator
{
    private CreatorId $id;
    private string $username;

    public function __construct(CreatorId $id, string $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function getId(): CreatorId
    {
        return $this->id;
    }
}

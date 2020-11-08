<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\Users;

class Role
{
    private RoleId $id;
    private string $name;

    public function __construct(RoleId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): RoleId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

<?php
declare(strict_types=1);

namespace App\Modules\Comments\Domain\Songs;

interface CommentRepository
{
    public function nextIdentity(): string;
}

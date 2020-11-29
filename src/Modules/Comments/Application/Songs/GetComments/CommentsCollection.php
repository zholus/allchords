<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

use App\Modules\Comments\Application\PaginationDto;

class CommentsCollection
{
    private string $songId;
    private array $comments;
    private PaginationDto $paginationDto;

    public function __construct(string $songId, PaginationDto $paginationDto, CommentDto ...$comments)
    {
        $this->songId = $songId;
        $this->paginationDto = $paginationDto;
        $this->comments = $comments;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getPaginationDto(): PaginationDto
    {
        return $this->paginationDto;
    }
}

<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

class CommentsDto
{
    private string $songId;
    /** @var CommentDto|array  */
    private array $comments;
    private PaginationDto $pagination;

    public function __construct(string $songId, array $comments, PaginationDto $pagination)
    {
        $this->songId = $songId;
        $this->comments = $comments;
        $this->pagination = $pagination;
    }

    public function getPagination(): PaginationDto
    {
        return $this->pagination;
    }

    public function toArray(): array
    {
        return [
            'song_id' => $this->songId,
            'comments' => array_map(static function(CommentDto $comment) {
                return $comment->toArray();
            }, $this->comments)
        ];
    }
}

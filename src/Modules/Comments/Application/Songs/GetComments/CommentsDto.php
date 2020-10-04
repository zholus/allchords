<?php
declare(strict_types=1);

namespace App\Modules\Comments\Application\Songs\GetComments;

use App\Modules\Comments\Application\Songs\GetComments\CommentDto;

class CommentsDto
{
    private string $songId;
    /** @var CommentDto|array  */
    private array $comments;

    public function __construct(string $songId, array $comments)
    {
        $this->songId = $songId;
        $this->comments = $comments;
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

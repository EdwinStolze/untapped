<?php

namespace Wireframe\Controller;


class CommentsController extends \Wireframe\Controller
{

    public function render()
    {
        echo $this->renderJSON();
    }

    public function renderJSON(): ?string
    {

        $comments = [];
        foreach ($this->page->comments as $comment) {
            array_push($comments, array(
                'id' => $comment->data,
                'date' => $comment->date,
                'timestamp' => $comment->timestamp,
                'comment' => $comment->comment,
            ));
        }

        return json_encode([
            'comments' => $comments,
        ]);
    }
}

<?php

namespace Wireframe\Controller;


class ChapterController extends \Wireframe\Controller
{

    public function defineArray($page) 
    {
        return array(
            'id'            => $page->id,
            'parent'        => $page->parent->id,
            'template'      => $page->template->name,
            'title'         => $page->title,
            'body'          => $page->body,
            'children'      => []
        );
    }

    public function render()
    {
        // var_dump($this->defineArray());
        $this->view->setLayout('json');
        $this->view->json = json_encode($this->defineArray($this->page), true);
    }

    public function renderJSON(): string
    {   
        return json_encode($this->defineArray($this->page), true);
    }

}

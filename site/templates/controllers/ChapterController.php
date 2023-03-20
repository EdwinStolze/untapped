<?php

namespace Wireframe\Controller;

use ProcessWire\ProcessWire;

class ChapterController extends \Wireframe\Controller
{
    protected $controllerArray = [];

    public function init() 
    {
        $this->controllerArray = $this->defineArray($this->page);
    }

    public static function defineArray($page) 
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
        $this->view->setLayout('json');
        $this->view->json = json_encode($this->controllerArray, true);
    }

    public function renderJSON(): string
    {   
        return json_encode($this->controllerArray, true);
    }

    public static function getChapter($page) 
    {
        return ChapterController::defineArray($page);
    }

    public static function getControllerArray($page) 
    {
        $controller = new ChapterController($page);
        $controller->init();
        return $controller->controllerArray;
    }


}

<?php

namespace Wireframe\Controller;

use ProcessWire\Wireframe;

class BasicPageController extends \Wireframe\Controller
{

    protected $controllerArray = [];

    public function init()
    {
        $this->controllerArray = $this->defineArray($this->page);
    }


    //TODO : duplication
    public static function getRouterName($next_page)
    {
        if ($next_page->template->name == 'basic-page') return 'textpage';
        if ($next_page->template->name == 'driver_clusters') return 'drivers';
        throw new \Exception('No router name found with this template.');
    }


    
    public static function defineArray($page)
    {
        return array(
            'id'                => $page->id,
            'parent'            => $page->parent->id,
            'template'          => $page->template->name,
            'title'             => $page->title,
            'body'              => $page->body,
            'next_page'         => $page->next_page->id,
            'button_name'       => $page->button_name,
            'button_type'       => $page->button->id,
            'router_name'       => $page->vue_router_name,
            'composer'          => Wireframe::component('ContentComposer')->create($page),
            'footer_buttons'    => Wireframe::component('FooterButtons')->create($page),
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
}

<?php

namespace Wireframe\Controller;


class DriverController extends \Wireframe\Controller
{

    public function defineArray($page) {
        return array(
            'id'            => $page->id,
            'parent'        => $page->parent->id,
            'template'      => $page->template->name,
            'title'         => $page->title,
            'driver_group'  => $page->parent->name,
            'driver_type'   => $page->driver_type->name,
            'long_title'    => $page->title_long,
            'icon_name'     => $page->icon_name,
            'explanation'   => $page->explanation,
            'children'      => [],
            'chapters'      => [],
            'quotes'        => [],
        );
    }

    public function getChildren() {
        $children = $this->page->children() ;
        var_dump($children);
    }

    public function render()
    {
        $this->view->setLayout('json');
        $this->view->json = json_encode($this->defineArray($this->page), true);
    }

    public function renderJSON(): string
    {   
        return json_encode($this->defineArray($this->page), true);
    }

}

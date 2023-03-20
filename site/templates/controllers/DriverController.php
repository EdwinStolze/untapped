<?php

namespace Wireframe\Controller;


class DriverController extends \Wireframe\Controller
{   
    protected $controllerArray = [];

    public function init() 
    {
        $this->controllerArray = $this->defineArray($this->page);
        $this->setChapters();
        $this->setDriverCluster();
        $this->setDriverCategory();
    }
    
    public static function defineArray($page) {
        return array(
            'id'                => $page->id,
            'parent'            => $page->parent->id,
            'template'          => $page->template->name,
            'title'             => $page->title,
            // 'driver_group'      => $page->parent->name,
            // 'driver_type'       => $page->driver_type->name,
            'long_title'        => $page->title_long,
            'icon_name'         => $page->icon_name,
            'explanation'       => $page->explanation,
            'chapters'          => [],
            'driver_cluster'    => 'bar',
            'driver_category'   => 'foo',
        );
    }
    
    public function setChapters() 
    {
        foreach($this->page->find('template=chapter') as $chapterPage) 
        {
            array_push(
                $this->controllerArray['chapters'],
                ChapterController::getChapter($chapterPage)
            );
        }
    }

    private function setDriverCluster() 
    {   
        $this->controllerArray['driver_cluster'] = $this->page->parent("template=driver_cluster")->id;
    }

    private function setDriverCategory() 
    {
        $this->controllerArray['driver_category'] = $this->page->driver_category->id;
        // TODO:: find from template where it in...
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

    public static function getControllerArray($page) 
    {
        $controller = new DriverController($page);
        $controller->init();
        return $controller->controllerArray;
    }

}

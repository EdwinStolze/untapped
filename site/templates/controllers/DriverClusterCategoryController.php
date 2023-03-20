<?php

namespace Wireframe\Controller;


class DriverClusterCategoryController extends \Wireframe\Controller
{   
    private $controllerArray = [];

    public function init() 
    {
        $this->controllerArray = $this->defineArray($this->page);
        $this->setDrivers();
    }
    
    public static function defineArray($page) {
        return array(
            'id'                => $page->driver_category->id,
            'title'             => $page->driver_category->title,
            'template'          => $page->driver_category->template->name,
            'name'              => $page->driver_category->name,
            'drivers'           => [],
        );
    }

    private function setDrivers() 
    {
        foreach($this->page->children('template=driver') as $driverPage) {
            $this->controllerArray['drivers'][] = DriverController::getControllerArray($driverPage);
        }
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
        $controller = new DriverClusterCategoryController($page);
        $controller->init();
        return $controller->controllerArray;
    }

}

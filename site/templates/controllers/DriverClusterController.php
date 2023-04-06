<?php

namespace Wireframe\Controller;


class DriverClusterController extends \Wireframe\Controller
{   
    private $controllerArray = [];

    public function init() 
    {
        $this->controllerArray = $this->defineArray($this->page);
        $this->setDrivers();
    }
    
    public static function defineArray($page) {
        return array(
            'id'                    => $page->id,
            'parent'                => $page->parent->id,
            'title'                 => $page->title,
            'template'              => $page->template->name,
            'name'                  => $page->name,
            'drivers'               => [],
        );
    }

    private function setDrivers() 
    {
        foreach($this->page->find('template=driver, sort=sort') as $driverPage) 
        {
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
        $controller = new DriverClusterController($page);
        $controller->init();
        return $controller->controllerArray;
    }


}

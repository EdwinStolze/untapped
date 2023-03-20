<?php

namespace Wireframe\Controller;


class DriversClustersController extends \Wireframe\Controller
{   
    private $controllerArray = [];

    public function init() 
    {
        $this->controllerArray = $this->defineArray($this->page);
        $this->setClusters();
    }
    
    public static function defineArray($page) {
        return array(
            'id'                    => $page->id,
            'parent'                => $page->parent->id,
            'title'                 => $page->title,
            'template'              => $page->template->name,
            'name'                  => $page->name,
            'drivers_clusters'      => [],
        );
    }

    private function setClusters() 
    {
        foreach($this->page->children('template=driver_cluster') as $driverClusterPage) {
            $this->controllerArray['drivers_clusters'][] = DriverClusterController::getControllerArray($driverClusterPage);
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


}

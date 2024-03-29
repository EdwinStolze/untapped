<?php

namespace Wireframe\Controller;

use ProcessWire\Wireframe;
class DriverClustersController extends \Wireframe\Controller
{   
    private $controllerArray = [];

    public function init() 
    {
        $this->controllerArray = $this->defineArray($this->page);
        $this->setClusters();
        $this->setCategories();
    }
    
    public static function defineArray($page) 
    {
        return array(
            'id'                    => $page->id,
            'parent'                => $page->parent->id,
            'title'                 => $page->title,
            'template'              => $page->template->name,
            'name'                  => $page->name,
            'body'                  => $page->body,
            'footer_buttons'        => Wireframe::component('FooterButtons')->create($page),
            'driver_clusters'       => [],
            'driver_categories'     => [],
        );
    }

    private function setClusters() 
    {
        foreach($this->page->children('template=driver_cluster') as $driverClusterPage) 
        {
            $this->controllerArray['driver_clusters'][] = DriverClusterController::getControllerArray($driverClusterPage);
        }
    }

    private function setCategories()
    {
        foreach($this->pages->find('template=driver_category') as $categoryPage) 
        {
            $this->controllerArray['driver_categories'][] = DriverCategoryController::getControllerArray($categoryPage);
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

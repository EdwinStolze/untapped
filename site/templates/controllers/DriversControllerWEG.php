<?php

namespace Wireframe\Controller;


class DriversController extends \Wireframe\Controller
{

    public function render()
    {
        // $this->renderJSON(); // Temp 

        // echo $this->wire('modules')->get('WireframeAPI')->init()->sendHeaders()->render();
        // $this->view->setLayout(null)->halt();
    }

    public function sortedDrivers() 
    {
    
        $driverslist = array();
    
        foreach ($this->pages->find("template=driver, sort=sort") as $driver) {

            $chapters = [];
            foreach ($driver->children() as $chapter) {
                array_push($chapters, array(
                    'id'            => $chapter->id,
                    'template'      => $chapter->template->name,
                    'title'         => $chapter->title,
                    'body'          => $chapter->body,
                ));
            }

            array_push($driverslist, array(
                'id'                => $driver->id,
                'name'              => $driver->name,
                'title'             => $driver->title,
                'driver_group'      => $driver->parent->name,
                'driver_group_id'   => $driver->parent->id,
                'driver_type'       => $driver->driver_type->name,
                'long_title'        => $driver->title_long,
                'icon_name'         => $driver->icon_name,
                'explanation'       => $driver->explanation,
                'chapters'          => $chapters,
                'quotes'            => [],
            ));
        }
        return $driverslist;
    }

    public function structuredDrivers() 
    {
        $driver_group_1 = array();
        foreach($this->page->children() as $driver_group1) {

            $driver_group_2 = array();
            foreach($driver_group1->children() as $driver_group2) {

                $drivers = array();
                foreach($driver_group2->children() as $driver) {

                    $chapters = [];
                    foreach ($driver->children() as $chapter) {
                        array_push($chapters, array(
                            'id'            => $chapter->id,
                            'template'      => $chapter->template->name,
                            'title'         => $chapter->title,
                            'body'          => $chapter->body,
                        ));
                    }

                    array_push($drivers, array(
                        'id'                => $driver->id,
                        'name'              => $driver->name,
                        'title'             => $driver->title,
                        'driver_group'      => $driver->parent->name,
                        'driver_group_id'   => $driver->parent->id,
                        'driver_type'       => $driver->driver_type->name,
                        'long_title'        => $driver->title_long,
                        'icon_name'         => $driver->icon_name,
                        'explanation'       => $driver->explanation,
                        'chapters'          => $chapters,
                    ));
                }

                array_push($driver_group_2, array(
                    'id'        => $driver_group2->id,
                    'title'     => $driver_group2->title,
                    'name'      => $driver_group2->name,
                    'template'  => $driver_group2->template->name,
                    'drivers'   => $drivers
                ));
            }

            array_push($driver_group_1, array(
                'id'        => $driver_group1->id,
                'title'     => $driver_group1->title,
                'name'      => $driver_group1->name,
                'template'  => $driver_group2->template->name,
                'driver_group' => $driver_group_2
            ));


        }


        return $driver_group_1 ;
    }


    public function renderJSON(): ?string
    {
        $driverslist = array(
            "version"               => 1,
            'next_page'             => $this->page->next_page->id,
            'vue_router_name'       => $this->page->vue_router_name,
            'button_type'           => $this->page->button_type,
            'button_name'           => $this->page->button_name,
            'body'                  => $this->page->body,
            'drivers'               => $this->sortedDrivers(),
            'structured_drivers'    => $this->structuredDrivers(),
        );

        return json_encode($driverslist, true);
    }
}

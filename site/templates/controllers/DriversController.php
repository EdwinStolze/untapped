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

    public function renderJSON(): ?string
    {
        $driverslist = array(
            "version"           => 1,
            'next_page'         => $this->page->next_page->id,
            'vue_router_name'   => $this->page->vue_router_name,
            'button_type'       => $this->page->button_type,
            'button_name'       => $this->page->button_name,
            'body'              => $this->page->body,
            'drivers'           => [],
            'table'             => [],
        );

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

            array_push($driverslist['drivers'], array(
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
        return json_encode($driverslist, true);
    }
}

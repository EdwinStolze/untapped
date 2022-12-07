<?php namespace Wireframe\Controller;
  

class DriversController extends \Wireframe\Controller {
  
    public function render() {
        echo $this->wire('modules')->get('WireframeAPI')->init()->sendHeaders()->render();
        $this->view->setLayout(null)->halt();
    }

    private function createDriverArray($driver) {
        
        $quotes = [];
        foreach($driver->quotes as $quote) {
            array_push($quotes, array(
                'quote' => $quote->quote,
                'author' => $quote->author
            ));
        }

        return array(
            'id' => $driver->id,
            'title' => $driver->title,
            'title_long' => $driver->title_long,
            'icon_name' => $driver->icon_name,
            'explanation' => $driver->explanation,
            'quotes' => $quotes,
        );
    }

    public function renderJSON(): ?string {
        $drivers_groups = array();
        foreach($this->pages->find("template=driver_group, sort=sort") as $driver_group) {
            foreach($driver_group->children() as $driver) {

                if ( ! isset( $drivers_groups[$driver->driver_type->name] ) ) {
                    $drivers_groups[$driver->driver_type->name]  = [];
                }

                if ( ! isset( $drivers_groups[$driver->driver_type->name][$driver_group->name] ) ) {
                    $drivers_groups[$driver->driver_type->name][$driver_group->name] = [];
                }

                $group = $drivers_groups[$driver->driver_type->name][$driver_group->name];
                array_push($drivers_groups[$driver->driver_type->name][$driver_group->name], $this->createDriverArray($driver));
            }
        }
        return json_encode($drivers_groups, true);
    }

}
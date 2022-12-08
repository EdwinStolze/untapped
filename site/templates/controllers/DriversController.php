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

    private function createDriverArray($driver)
    {

        $quotes = [];
        foreach ($driver->quotes as $quote) {
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

    public function &getItemFromArray($key, $value, &$array)
    {
        foreach ($array as &$item) {
            if ($item[$key] == $value) return $item;
        }
        return FALSE;
    }

    public function renderJSON(): ?string
    {
        $driverslist = array(
            "version" => 1,
            "types" => []
        );

        foreach ($this->pages->find("template=driver, sort=sort") as $driver) {

            // Create drivers group for driver_type
            if (!$this->getItemFromArray('id', $driver->driver_type->id, $driverslist['types'])) {

                $driver_groups = [];
                foreach ($this->pages->find("template=driver_group") as $driver_group) {
                    array_push($driver_groups, array(
                        "id" => $driver_group->id,
                        "name" => $driver_group->name,
                        "drivers" => []
                    ));
                }

                // Create drive_type
                array_push(
                    $driverslist['types'],
                    array(
                        "id" => $driver->driver_type->id,
                        "name" => $driver->driver_type->name,
                        "groups" => $driver_groups
                    )
                );
                
            }

            // Add driver to the appropriate driver group
            $type   = &$this->getItemFromArray('id', $driver->driver_type->id, $driverslist['types']);
            $group  = &$this->getItemFromArray('id', $driver->parent->id, $type ['groups']);
            $group['drivers'][] = $this->createDriverArray($driver);

        }
        return json_encode($driverslist, true);
    }

}

<?php

namespace Wireframe\Controller;


class BasicPage2Controller extends \Wireframe\Controller
{

    protected $controllerArray = [];

    public function init()
    {
        $this->controllerArray = $this->defineArray($this->page);
        $this->build();
    }
    
    public static function defineArray($page)
    {
        return array(
            'id'                => $page->id,
            'parent'            => $page->parent->id,
            'template'          => $page->template->name,
            'title'             => $page->title,
            'body'              => $page->body,
            'next_page'         => $page->next_page->id,
            'button_name'       => $page->button_name,
            'button_type'       => $page->button->id,
            'composer'          => []
        );
    }


    /**
     * Build an array of all the content_composer items.
     */
    private function build()
    {
        foreach ($this->page->content_composer as $item) {
            if ($item->type == 'rm_body') $this->controllerArray['composer'][]      = $this->build_rm_body($item);
            if ($item->type == 'rm_steps') $this->controllerArray['composer'][]     = $this->build_rm_steps($item);
            if ($item->type == 'rm_buttons') $this->controllerArray['composer'][]   = $this->build_rm_buttons($item);
            if ($item->type == 'rm_accordion') $this->controllerArray['composer'][] = $this->build_rm_accordion($item);
            if ($item->type == 'rm_comments') $this->controllerArray['composer'][]  = $this->build_rm_comments($item);
        }
    }

    private function build_rm_body($item)
    {
        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
            'body'              => $item->body,
        );
    }

    private function build_rm_steps($item)
    {
        foreach ($item->steps as $step) 
        {
            $steps[] = array(
                'number'    => 1,
                'summary'   => $step->summary
            );
        }

        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
            'steps'             => $steps,
        );
    }

    private function build_rm_buttons($item)
    {
        foreach ($item->page_buttons as $button) 
        {
            $buttons[] = array(
                'title'       => $button->title,
                'next_page'   => $button->next_page->id,
            );
        }

        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
            'buttons'           => $buttons,
        );
    }

    private function build_rm_accordion($item)
    {
        foreach ($item->accordion as $acc_item) 
        {
            $accordion[] = array(
                'title'  => $acc_item->title,
                'body'   => $acc_item->body,
            );
        }

        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
            'accordion_items'   => $accordion,
        );
    }

    private function build_rm_comments($item)
    {
        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
        );
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

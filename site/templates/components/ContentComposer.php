<?php

namespace Wireframe\Component;

/**
 * Card component
 */
class ContentComposer extends \Wireframe\Component {

    /**
     * Constructor method
     *
     * @param \ProcessWire\Page $item Page related to current Card.
     */
    public function __construct(\ProcessWire\Page $item) {

    }

        /**
     * Build an array of all the content_composer items.
     */
    public static function create($page)
    {   
        $controllerArray = [];
        foreach ($page->content_composer as $item) {
            if ($item->type == 'rm_body') $controllerArray[]      = ContentComposer::build_rm_body($item);
            if ($item->type == 'rm_steps') $controllerArray[]     = ContentComposer::build_rm_steps($item);
            if ($item->type == 'rm_buttons') $controllerArray[]   = ContentComposer::build_rm_buttons($item);
            if ($item->type == 'rm_accordion') $controllerArray[] = ContentComposer::build_rm_accordion($item);
            if ($item->type == 'rm_comments') $controllerArray[]  = ContentComposer::build_rm_comments($item);
        }
        return $controllerArray;
    }

    private static function build_rm_body($item)
    {
        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
            'body'              => $item->body,
        );
    }

    private static function build_rm_steps($item)
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

    private static function build_rm_buttons($item)
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

    private static function build_rm_accordion($item)
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

    private static function build_rm_comments($item)
    {
        return (object) array(
            'id'                => $item->id,
            'item_type'         => $item->type,
        );
    }

}
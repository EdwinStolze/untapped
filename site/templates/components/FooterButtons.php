<?php

namespace Wireframe\Component;

/**
 * Card component
 */
class FooterButtons extends \Wireframe\Component {

    /**
     * Constructor method
     *
     * @param \ProcessWire\Page $item Page related to current Card.
     */
    public function __construct(\ProcessWire\Page $item=null) {

    }

    // TODO:: waarschijnlijk een composable
    public static function getRouterName($next_page)
    {
        // var_dump($next_page->template->name);    
        if ($next_page->template->name == 'basic-page') return 'textpage';
        if ($next_page->template->name == 'questionaires') return 'step1';
        throw new \Exception('No router name found with this template.');
    }

    /**
     * Build an array of all the content_composer items.
     */
    public static function create($page)
    {   
        $controllerArray = array();
        foreach ($page->footerbuttons as $fb) 
        {
            if (!$fb->next_page) continue;
            $controllerArray[] = array(
                'id'          => $fb->id,
                'title'       => $fb->button_name,
                'type'        => $fb->button->id,
                'next_page'   => $fb->next_page->id,
                'pulse'       => $fb->pulse,
                'reversed'       => $fb->reversed,
                'router_name' => FooterButtons::getRouterName($fb->next_page),
            );
        }
        
        return $controllerArray;
    }

}
<?php

namespace Wireframe\Controller;

/**
 * Controller class for the API template
 */
class APIController extends \Wireframe\Controller {

    /**
     * Render method
     */
    public function render() {
        // echo $this->wire('modules')->get('WireframeAPI')->init()->sendHeaders()->render();
        $api = $this->wire('modules')->get('WireframeAPI') ;
        echo $api->init()->sendHeaders()->render();
        $this->view->setLayout(null)->halt();
    }

    public function renderJSON(): ?string {
        return json_encode([
            "title" => $this->page->title,
            "body" => $this->page->body,
            "firstChild" => $this->page->children->first->id,
            "nextPage" => $this->page->next()->id
        ]);
    }

}



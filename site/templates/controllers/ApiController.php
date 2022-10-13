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
        $api = $this->wire('modules')->get('WireframeAPI') ;
        $api->addEndpoint('basic-page', function($path, $args) {
            // var_dump($path);
            $this->page = $this->pages->get("template=basic-page,name=".$path[0]);
            return [
                'path' => $path,
                'args' => $args,
                // 'url' => $this->pages->get(1042)->url,
                'url' => $this->page->url,
                'json' => [
                    "title" => $this->page->title,
                    "body" => $this->page->body,
                    "firstChild" => $this->page->children->first->id,
                    "nextPage" => $this->page->next()->id
                ]
            ];
        });
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



<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */


 
class BasicPageController extends \Wireframe\Controller {
  
    /**
     * Render method
     */
    public function render() {
        $api = $this->wire('modules')->get('WireframeAPI')->init(); 
        echo $api->sendHeaders()->render();
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
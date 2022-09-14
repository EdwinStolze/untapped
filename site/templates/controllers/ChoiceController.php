<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class ChoiceController extends \Wireframe\Controller {
  
    /**
     * Render method gets executed automatically when page is rendered.
     */
    public function render() {
        $this->view->nextPage = $this->page->children("template=questions");
    }
 
}
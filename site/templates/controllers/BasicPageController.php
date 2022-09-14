<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class HomeController extends \Wireframe\Controller {
  
    /**
     * Render method gets executed automatically when page is rendered.
     */
    public function render() {
        $this->view->some_var = "some value";
    }
 
}
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
  
    /**
     * Another method. Controller methods can be accessed as parameters from
     * within Layout files and View Files.
     *
     * @return string
     */
    public function someOtherVar(): string {
        return "some other value";
    }
  
}
<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class HomeController extends \Wireframe\Controller {
  
    public function renderJSON(): ?string {

        return json_encode([
            "title" => $this->page->title,
            "body" => $this->page->body,
            "accordion" => $accordion,
            "nextPageID" => $this->page->next()->id
            "routerpath" => $this->page->routerpath
        ]);
    }
 
}
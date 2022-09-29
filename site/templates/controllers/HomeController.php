<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class HomeController extends \Wireframe\Controller {
  
    public function renderJSON(): ?string {

        return json_encode([
            'title' => $this->page->title,
            // 'body' => $this->page->body,
            'next_page' => $this->page->next()->id,
            'vue_router_name' => $this->page->vue_router_name,
            'button_type' => $this->page->button_type,
            'button_name' => $this->page->button_name
        ]);

    }
 
}
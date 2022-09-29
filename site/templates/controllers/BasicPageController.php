<?php
  
namespace Wireframe\Controller;
  

class BasicPageController extends \Wireframe\Controller {
    
    public function renderJSON(): ?string {

        $accordion = [];
        foreach($this->page->accordion as $accItem) {
            array_push($accordion, array(
                'id' => $accItem->id,
                'title' => $accItem->title,
                'body' => $accItem->body,
            ));
        }

        return json_encode([
            'title' => $this->page->title,
            'body' => $this->page->body,
            'accordion' => $accordion,
            'next_page' => $this->page->next()->id,
            'vue_router_name' => $this->page->vue_router_name,
            'button_type' => $this->page->button_type,
            'button_name' => $this->page->button_name
        ]);
    }
 
}
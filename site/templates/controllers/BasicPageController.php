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
            "title" => $this->page->title,
            "body" => $this->page->body,
            "accordion" => $accordion,
            "firstChild" => $this->page->children->first->id,
            "nextPage" => $this->page->next()->id
        ]);
    }
 
}
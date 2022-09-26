<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class QuestionairesController extends \Wireframe\Controller {
  
    public function render() {
        $api = $this->wire('modules')->get('WireframeAPI') ;
        echo $api->init()->sendHeaders()->render();
        $this->view->setLayout(null)->halt();
    }

    public function renderJSON(): ?string {
        
        $data = [];
        foreach($this->page->children as $p) {

            array_push($data, array(
                'id' => $p->id,
                'title' => $p->title,
                'name' => $p->name,
            ));
        }
        return json_encode($data, true);
    }

}
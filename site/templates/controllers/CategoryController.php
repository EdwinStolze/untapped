<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class CategoryController extends \Wireframe\Controller {
  
    public function render() {

        $categories  = $this->pages->find("template=category");
        bd($categories);
        $catArray = $categories->data ;
        bd($catArray);

        // echo $this->wire('modules')->get('WireframeAPI')->init()->sendHeaders()->render();
        // $this->view->setLayout(null)->halt();
    }

    public function renderJSON(): ?string {

        $scoring = [];
        foreach($this->page->scoring as $si) {
            array_push($scoring, array(
                'score_value' => $si->score_value,
                'score_label' => $si->score_label,
                'score_description' => $si->score_description
            ));
        }

        var_dump($scoring);

        return json_encode([
            "title" => $this->page->title,
            "explanation" => $this->page->explanation,
            "scoring" => $scoring
            // "firstChild" => $this->page->children->first->id,
            // "nextPage" => $this->page->next()->id,
        ]);
    }

}
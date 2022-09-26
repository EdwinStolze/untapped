<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class CategoriesController extends \Wireframe\Controller {
  

    public function renderJSON(): ?string {

        $categories = [];


        foreach($this->pages->find("template=category") as $cat ) {
            
            $scoring = [];
            foreach($cat->scoring as $si) {
                array_push($scoring, array(
                    'score_value' => $si->score_value,
                    'score_label' => $si->score_label,
                    'score_description' => $si->score_description
                ));
            }

            array_push($categories, array(
                'id' => $cat->id,
                'name' => $cat->name,
                'title' => $cat->title,
                'explanation' => $cat->explanation,
                'scoring' => $scoring
            ));
        }

        return json_encode($categories);
    }

}
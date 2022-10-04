<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class QuestionaireController extends \Wireframe\Controller {
  
    public function render() {
        echo $this->wire('modules')->get('WireframeAPI')->init()->sendHeaders()->render();
        $this->view->setLayout(null)->halt();
        // var_dump($this->renderJSON());
    }

    public function renderJSON(): ?string {

        
        $questions = [];
        foreach($this->page->find("template=question, sort=sort") as $question) {
            
            
            $scoringOptions = [];
            foreach($question->scoring as $score) {
                array_push($scoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                    'score_description' => $score->score_description
                ));
            }

            array_push($questions, array(
                'id' => $question->id,
                'title' => $question->title,
                'question'   => $question->question,
                'explanation' => $question->explanation,
                'scoringOptions' => $scoringOptions,
                'userScore' => 0
            ));
        }

        $sortables = [];
        foreach($this->page->sortables as $sortable) {
            array_push($sortables, $sortable->sort_item);
        }

        $categories = [];
        foreach($this->page->find("template=category") as $category) {

            $scoringOptions = [];
            foreach($category->scoring as $score) {
                array_push($scoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                    'score_description' => $score->score_description
                ));
            }

            array_push($categories, array(
                'id' => $category->id,
                'title' => $category->title,
                'explanation' => $category->explanation,
                'scoringOptions' => $scoringOptions,
            ));
        }

        $data = array(
            'companyName' => '',
            'questionaireID' => $this->page->id,
            'version' => 1,
            'defaultScoringOptions' => $scoringOptions,
            'questions' => $questions,
            'sortables' => $sortables,
            'categories' => $categories
        );

        return json_encode($data, true);
    }

}
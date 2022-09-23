<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class QuestionaireController extends \Wireframe\Controller {
  
    
    public function render() {
        echo $this->wire('modules')->get('WireframeAPI')->init()->sendHeaders()->render();
        $this->view->setLayout(null)->halt();
    }


    public function renderJSON(): ?string {

        $scoringOptions = [];
        foreach($this->page->scoring as $score) {
            array_push($scoringOptions, array(
                'score_value' => $score->score_value,
                'score_label' => $score->score_label,
                'score_description' => $score->score_description
            ));
        }

        $questions = [];
        foreach($this->page->children() as $question) {
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
        foreach($this->page->sortables as $sortable ) {
            array_push($sortables, $sortable->sort_item);
        }

        $data = array(
            'companyName' => "My Company name",
            // 'defaultScoringOptions' => $scoringOptions,
            'questions' => $questions,
            'sortables' => $sortables
        );

        return json_encode($data, true);
    }

}
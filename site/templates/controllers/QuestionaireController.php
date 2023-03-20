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
                'icon' => $question->driver->icon_name,
                'icon_title' => $question->driver->title,
                'question'   => $question->question,
                'result_id' => $question->results->id,
                'result_title' => $question->results->title,
                'explanation' => $question->explanation,
                'scoringOptions' => $scoringOptions,
                'userScore' => 0
            ));
        }

        $sortables = [];
        foreach($this->page->sortables as $sortable) {
            array_push($sortables, $sortable->sort_item);
        }

        $defaultScoringOptions = [];
        foreach($this->page->scoring as $score) {
            array_push($defaultScoringOptions, array(
                'score_value' => $score->score_value,
                'score_label' => $score->score_label,
                'score_description' => $score->score_description
            ));
        }


        $results = [];
        foreach($this->page->find("template=result") as $result) {

            $catScoringOptions = [];
            foreach($result->scoring as $score) {
                array_push($catScoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                    'score_description' => $score->score_description
                ));
            }

            array_push($results, array(
                'id' => $result->id,
                'title' => $result->title,
                'explanation' => $result->explanation,
                'scoringOptions' => $catScoringOptions,
            ));
        }

        $data = array(
            'companyName' => '',
            'questionaireID' => $this->page->id,
            'version' => $this->page->version,
            'hash' => $this->page->hash,
            'strapline' => $this->page->strapline,
            'defaultScoringOptions' => $defaultScoringOptions,
            'questions' => $questions,
            'sortablesText' => $this->page->sortablestext,
            'sortables' => $sortables,
            'results' => $results
        );

        return json_encode($data, true);
    }

}
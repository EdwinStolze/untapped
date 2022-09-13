<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class QuestionsController extends \Wireframe\Controller {
  
    /**
     * Render method gets executed automatically when page is rendered.
     */
    public function render() {
        if ($this->input->urlSegment1() == 'api') {
            $this->view->setLayout('json');
        }
    }

    public function getJson() {

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

        $data = array(
            'companyName' => "Mac Donalds",
            'defaultScoringOptions' => $scoringOptions,
            'questions' => $questions,
        );
        return json_encode($data, true);
    }
}
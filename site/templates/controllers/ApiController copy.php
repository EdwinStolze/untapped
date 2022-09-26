<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class ApiController extends \Wireframe\Controller {
  
    public function render() {
        $this->view->setLayout('json');
        
        if ($this->input->urlSegment1() == 'base') {
            $this->view->json = $this->getBaseJson();
            return;
        }
        $selector = "name={$this->input->urlSegment1}";
        // var_dump($selector);
        $questionsPage = $this->pages->get($selector);
        $this->view->json = $this->getQuestionsJson($questionsPage);
    }
    
    public function getBaseJson() {

        // Define general information
        $app = array(
            'introduction' => $this->pages->get('template=intro')->body,
            'questionaires' => []
        );
    
        // Define questionaire
        foreach($this->pages->find("template=questionaire") as $questionairePage) {
            $q = array (
                'id' => $questionairePage->id,
                'title' => $questionairePage->title,
                'api' => $questionairePage->url,
                'questions' => null,
                'companyName' => 'null',
                'email' => '',
            );
            array_push($app['questionaires'], $q);
        }
    
        // bd($data);
        return json_encode($app, true);
        
    }

    public function getQuestionsJson($questionsPage) {

        $scoringOptions = [];
        foreach($questionsPage->scoring as $score) {
            array_push($scoringOptions, array(
                'score_value' => $score->score_value,
                'score_label' => $score->score_label,
                'score_description' => $score->score_description
            ));
        }

        $questions = [];
        foreach($questionsPage->children() as $question) {
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
            'defaultScoringOptions' => $scoringOptions,
            'questions' => $questions,
        );
        return json_encode($data, true);
    }
 
}
<?php
  
namespace Wireframe\Controller;
  
/**
 * This is the Controller class for the home template.
 */
class BackendController extends \Wireframe\Controller {
  
    /**
     * Render method gets executed automatically when page is rendered.
     */
    public function render() {

        $data = json_decode(file_get_contents('php://input'), true);
        $average = $this->processResults($data);
        $this->view->setLayout('json');
        // bd($data);
        return json_encode(array(
            'average_score' => $average
        ), true);

    }

    public function processResults($data) {

        $score = 0;
        foreach($data['questions'] as $question) {
            $score = $score + $question['userScore'];
            // bd($question['userScore']);
        }
        $averageScore = $score / count($data['questions']);
        return $averageScore;
    }
 
}
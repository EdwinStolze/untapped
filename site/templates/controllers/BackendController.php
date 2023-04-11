<?php
  
namespace Wireframe\Controller;
  
class BackendController extends \Wireframe\Controller {
  
    public function init()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET,POST, HEAD');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
    }
    
    
    public function render() {
        
        $this->view->setLayout('json'); 
        $results = json_decode(file_get_contents('php://input'), false); //true naar // als object
        
        // Process comments
        if (isset($results->comment)) {
            $processComments = $this->processComments($results);
            $processComments = json_encode($processComments, true);
            $this->view->json = $processComments;
        }


        // Process questionaire results
        if (isset($results->questionaireID)) {
            $this->log->error('init processing'); 
            $processedResults = $this->processResults($results);
            $processedResults = json_encode($processedResults, true);
            $this->view->json = $processedResults;
        }
    }

    public function processComments($resultObject) {
        $commentsPage = $this->pages->get('template=comments');
        $commentsPage->of(false);
        $comment = $commentsPage->comments->makeBlankItem();
        $comment->comment = $resultObject->comment;
        $comment->timestamp = $this->datetime->date();
        $comment->date = $this->datetime->date();
        $commentsPage->comments->add($comment);
        $commentsPage->save('comments');

        // Define json response
        $comments = [];
        foreach ($this->pages->get('template=comments')->comments as $comment) {
            array_push($comments, array(
                'id' => $comment->data,
                'date' => $comment->date,
                'timestamp' => $comment->timestamp,
                'comment' => $comment->comment,
            ));
        }
        return $comments;
    }

    public function processResults($resultObject) {

        $questionairePage = $this->pages->get($resultObject->questionaireID);
        $questionaireParentPage = $questionairePage->get("template=results");
        $results = $questionaireParentPage->children();

        $resultsArray = array(
            'questionaireID' => $resultObject->questionaireID,
            'version' => $resultObject->version,
            'hash' => $resultObject->hash,
            'results' => []
        );

        // Create categories array
        $resultArray = [];
        foreach($results as $result) {



            $scoringOptions = [];
            foreach($result->scoring as $score) {
                array_push($scoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                ));
            }
            $res = array(
                'id' => $result->id,
                'title' => $result->title,
                'show' => $result->showinresults,
                'explanation' => '',
                'amount' => 0,
                'scoreSum' => 0,
                'show' => true,
                'scoreAverage' => 1,
                'scoringOptions' => $scoringOptions,
                'strapLine' => $result->strapline
            );
            array_push($resultsArray['results'], $res);
        }

        
        // Collect data
        foreach($resultObject->results as $result) 
        {
            $questionPage = $this->pages->get($result->id);
            if (!$questionairePage) continue;
            $res = $questionPage->results;
            if (!$res) continue; // TODO geen result set dan overslaan...
            $key = array_search($res->id, array_map(function($v){return $v['id'];},$resultsArray['results']));
            $resultsArray['results'][$key]['amount']++;
            $resultsArray['results'][$key]['scoreSum'] = $resultsArray['results'][$key]['scoreSum'] + $result->userScore ;
            
            // Indien resultaten ook in een andere result verwerkt moeten worden.
            if ($res->add_results_to) {
                $key = array_search($res->add_results_to->id, array_map(function($v){return $v['id'];},$resultsArray['results']));
                $resultsArray['results'][$key]['amount']++;
                $resultsArray['results'][$key]['scoreSum'] = $resultsArray['results'][$key]['scoreSum'] + $result->userScore ; 
            }
        }   
        
        // Process averages
        foreach($resultsArray['results'] as &$res) 
        {
            $average = 0;
            if ( $res['amount'] ) 
            {
                $average = $res['scoreSum'] / $res['amount'];
            } 
            $roundedAverage = (int)round($average, 0, PHP_ROUND_HALF_DOWN);
            $res['scoreAverage'] = $roundedAverage;
            $roundedAverage = $roundedAverage ? $roundedAverage : 1; // LET OP 0 wordt 1 maar we moeten een foutmelding geven.
            if ($this->pages->get($res['id'])->scoring->count) {
                $explanation = $this->pages->get($res['id'])->scoring->get('score_value='.$roundedAverage)->score_description;
                $res['explanation'] = $explanation;
            }
        }

        return $resultsArray;

    }
 
}
<?php
  
namespace Wireframe\Controller;
  
class BackendController extends \Wireframe\Controller {
  
    /**
     * Render method gets executed automatically when page is rendered.
     */
    public function render() {

        $this->view->setLayout('json');
        $results = json_decode(file_get_contents('php://input'), false); //true naar // als object
        $processedResults = $this->processResults($results);
        $processedResults = json_encode($processedResults, true);
        $this->view->json = $processedResults;
    }

    public function processResults($resultObject) {

        $questionairePage = $this->pages->get($resultObject->questionaireID);
        $categoryParentPage = $questionairePage->get("template=categories");
        $categories = $categoryParentPage->children();

        $resultsArray = array(
            'questionaireID' => $resultObject->questionaireID,
            'version' => $resultObject->version,
            'hash' => $resultObject->hash,
            'results' => []
        );

        // Create categories array
        $resultArray = [];
        foreach($categories as $category) {
            $scoringOptions = [];
            foreach($category->scoring as $score) {
                array_push($scoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                ));
            }
            $res = array(
                'id' => $category->id,
                'title' => $category->title,
                'show' => $category->showinresults,
                'explanation' => '',
                'amount' => 0,
                'scoreSum' => 0,
                'scoreAverage' => 1,
                'scoringOptions' => $scoringOptions,
                'strapLine' => $category->strapline
            );
            array_push($resultsArray['results'], $res);
        }
        
        // Collect data
        foreach($resultObject->results as $result) {

            $questionPage = $this->pages->get($result->id);
            if (!$questionairePage) continue;
            $cat = $questionPage->categories;
            if (!$cat) continue;
            $key = array_search($cat->id, array_map(function($v){return $v['id'];},$resultsArray['results']));
            $resultsArray['results'][$key]['amount']++;
            $resultsArray['results'][$key]['scoreSum'] = $resultsArray['results'][$key]['scoreSum'] + $result->userScore ;
        }

        // Process averages
        foreach($resultsArray['results'] as &$cat) {
            $average = $cat['scoreSum'] / $cat['amount'];
            $roundedAverage = (int)round($average, 0, PHP_ROUND_HALF_DOWN);
            $cat['scoreAverage'] = $roundedAverage;
            $roundedAverage = $roundedAverage ? $roundedAverage : 1; // LET OP 0 wordt 1 maar we moeten een foutmelding geven.
            if ($this->pages->get($cat['id'])->scoring->count) {
                $explanation = $this->pages->get($cat['id'])->scoring->get('score_value='.$roundedAverage)->score_description;
                $cat['explanation'] = $explanation;
            }
        }

        return $resultsArray;

    }
 
}
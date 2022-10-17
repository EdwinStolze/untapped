<?php
  
namespace Wireframe\Controller;
  
class BackendController extends \Wireframe\Controller {
  
    /**
     * Render method gets executed automatically when page is rendered.
     */
    public function render() {

        $this->view->setLayout('json');
        $results = json_decode(file_get_contents('php://input'), false); //true naar false getr
        $processedResults = $this->processResults($results);
        $processedResults = json_encode($processedResults, true);
        $this->view->json = $processedResults;
    }

    // private function 
    // TODO:: aanpassen json file to encorporate questionaireID.

    public function processResults($results) {

        $questionairePage = $this->pages->get(1047)->parent;
        $categoryParentPage = $questionairePage->get("template=categories");
        $categories = $categoryParentPage->children();

        $resultsArray = array(
            'questionaireID' => $questionairePage->id,
            'version' => 1,  // todo version number verwerking
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
        foreach($results as $result) {

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

    public function processResultsOLD($results) {

        $categoryParent = $this->pages->get($results[0]->id)->parent->parent->get("template=categories");

        // Create categories array
        $resultsArray = [];
        foreach($categoryParent->children() as $category) {
            $scoringOptions = [];
            foreach($category->scoring as $score) {
                array_push($scoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                    // 'score_description' => $score->score_description
                ));
            }

            $resultsArray[$category->id] = array(
                'id' => $category->id,
                'title' => $category->title,
                'explanation' => '',
                'amount' => 0,
                'scoreSum' => 0,
                'scoreAverage' => 1,
                'scoringOptions' => $scoringOptions,
                'strapLine' => $category->strapline
            );
        }

        // Collect data
        foreach($results as $result) {
            $cat = $this->pages->get($result->id)->categories;
            $resultsArray[$cat->id]['amount']++;
            $resultsArray[$cat->id]['scoreSum'] = $resultsArray[$cat->id]['scoreSum'] + $result->userScore ;
        }

        // Process averages
        foreach($resultsArray as &$cat) {
            $average = $cat['scoreSum'] / $cat['amount'];
            $roundedAverage = (int)round($average, 0, PHP_ROUND_HALF_DOWN);
            $cat['scoreAverage'] = $roundedAverage;
            $roundedAverage = $roundedAverage ? $roundedAverage : 1; // LET OP 0 wordt 1 maar we moeten een foutmelding geven.
            $explanation = $this->pages->get($cat['id'])->scoring->get('score_value='.$roundedAverage)->score_description;
            $cat['explanation'] = $explanation;
        }

        return $resultsArray;

    }
 
}
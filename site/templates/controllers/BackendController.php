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

        $this->view->setLayout('json');
        // $results = '[{"id":1071,"userScore":3},{"id":1044,"userScore":3},{"id":1072,"userScore":3},{"id":1040,"userScore":3},{"id":1039,"userScore":3},{"id":1045,"userScore":3},{"id":1041,"userScore":3},{"id":1073,"userScore":3},{"id":1074,"userScore":3},{"id":1075,"userScore":3},{"id":1091,"userScore":3},{"id":1092,"userScore":3},{"id":1093,"userScore":3},{"id":1094,"userScore":3},{"id":1099,"userScore":3},{"id":1100,"userScore":3},{"id":1101,"userScore":3},{"id":1102,"userScore":3},{"id":1103,"userScore":3},{"id":1104,"userScore":3},{"id":1105,"userScore":3},{"id":1106,"userScore":5},{"id":1107,"userScore":3},{"id":1108,"userScore":3},{"id":1109,"userScore":3},{"id":1110,"userScore":3},{"id":1111,"userScore":3},{"id":1112,"userScore":3},{"id":1113,"userScore":3},{"id":1114,"userScore":3},{"id":1115,"userScore":3},{"id":1116,"userScore":3},{"id":1117,"userScore":3},{"id":1118,"userScore":3},{"id":1119,"userScore":3},{"id":1120,"userScore":3},{"id":1121,"userScore":3},{"id":1122,"userScore":3},{"id":1123,"userScore":3},{"id":1124,"userScore":3},{"id":1126,"userScore":3},{"id":1125,"userScore":3},{"id":1127,"userScore":3},{"id":1128,"userScore":3},{"id":1129,"userScore":3},{"id":1130,"userScore":3},{"id":1131,"userScore":3},{"id":1132,"userScore":3},{"id":1133,"userScore":3},{"id":1141,"userScore":3},{"id":1135,"userScore":3},{"id":1136,"userScore":3},{"id":1137,"userScore":3},{"id":1138,"userScore":3},{"id":1139,"userScore":3},{"id":1142,"userScore":3},{"id":1143,"userScore":3},{"id":1144,"userScore":3},{"id":1145,"userScore":3},{"id":1146,"userScore":3},{"id":1147,"userScore":3},{"id":1148,"userScore":3}]';
        $results = json_decode(file_get_contents('php://input'), false); //true naar false getr
        $this->wire('log')->save('untapped', json_encode($results));
        // $results = json_decode($results);
        $processedResults = $this->processResults($results);
        $processedResults = json_encode($processedResults, true);
        $this->view->json = $processedResults;
    }

    // private function 

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
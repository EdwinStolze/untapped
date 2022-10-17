<?php

namespace Wireframe\Controller;

/**
 * Controller class for the API template
 */
class APIController extends \Wireframe\Controller {

    /**
     * Render method
     */
    public function render() {

        $this->page = $this->pages->get("template={$this->input->urlSegment1()}, name=" . $this->input->urlSegment2());

        $this->view->setLayout(null)->halt();
        $api = $this->wire('modules')->get('WireframeAPI') ;
        // Add custom api's
        $this->textViewAPI($api);
        $this->questionaireAPI($api);
        return $api->init()->sendHeaders()->render();
    }

    public function questionaireAPI($api) {
        $api->addEndpoint('questionaire', function($path, $args) {
            // $this->page = $this->pages->get("template=questionaire, name=".$path[0]);

            $defaultScoringOptions = [];
            foreach($this->page->scoring as $score) {
                array_push($defaultScoringOptions, array(
                    'score_value' => $score->score_value,
                    'score_label' => $score->score_label,
                ));
            }

            $sortables = [];
            foreach($this->page->sortables as $sortable) {
                array_push($sortables, $sortable->sort_item);
            }

            $questions = [];
            foreach($this->page->get("template=questions")->children() as $question) {

                $scoringOptions = [];
                foreach($question->scoring as $score) {
                    array_push($scoringOptions, array(
                        'score_value' => $score->score_value,
                        'score_label' => $score->score_label,
                    ));
                }

                array_push($questions, array(
                    'id' => $question->id,
                    'title' => $question->title,
                    'icon' => $question->driver->icon_name,
                    'questions' => $question->question,
                    'explanation' => $question->explanation,
                    'scoringOptions' => $scoringOptions,
                    'userScore' => 0,

                ));
            }

            return [
                'path' => $path,
                'args' => $args,
                'url' => $this->page->url,
                'json' => [
                    "companyName" => '',
                    "questionaireID" => $this->page->id,
                    "version" => $this->page->version,
                    "hash" => $this->page->hash,
                    "defaultScoringOptions" => $defaultScoringOptions,
                    "questions" => $questions,
                    "sortableText" => $this->page->sortablestext,
                    "sortables" => $sortables,
                    "next_page" => $this->page->next_page ? $this->page->next_page->id : false,
                    "vue_router_name" => $this->page->vue_router_name,
                    "button_type" => $this->page->button_type,
                    "button_name" => $this->page->button_name,
                ]
            ];
        });
        return $api;
    }

    public function textViewAPI($api) {
        $api->addEndpoint('basic-page', function($path, $args) {
            // $this->page = $this->pages->get("template=basic-page,name=".$path[0]);
            $accordion = [];
            foreach($this->page->accordion as $acc) {
                array_push($accordion,[
                    'id'    => $acc->id, 
                    'title' => $acc->title,
                    'body'  => $acc->body,
                ]);
            }
            return [
                'path' => $path,
                'args' => $args,
                'url' => $this->page->url,
                'json' => [
                    "title" => $this->page->title,
                    "body" => $this->page->body,
                    "accordion" => $accordion,
                    "next_page" => $this->page->next_page ? $this->page->next_page->id : false,
                    "vue_router_name" => $this->page->vue_router_name,
                    "button_type" => $this->page->button_type,
                    "button_name" => $this->page->button_name,
                ]
            ];
        });
        return $api;
    }
    
    public function renderJSON(): ?string {
        return json_encode([
            "title" => $this->page->title,
            "body" => $this->page->body,
            // "accordion" => $this->page->body,
            "next_page" => $this->page->next_page,
            "vue_router_name" => $this->page->vue_router_name,
            "button_type" => $this->page->button_type,
            "button_name" => $this->page->button_name,

        ]);
    }

}



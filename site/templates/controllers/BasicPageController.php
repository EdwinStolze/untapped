<?php

namespace Wireframe\Controller;


class BasicPageController extends \Wireframe\Controller
{

    public function render()
    {
        echo $this->renderJSON();
    }

    public function renderJSON(): ?string
    {

        $accordion = [];
        foreach ($this->page->accordion as $accItem) {
            array_push($accordion, array(
                'id' => $accItem->id,
                'title' => $accItem->title,
                'body' => $accItem->body,
            ));
        }

        $page_buttons = [];
        foreach ($this->page->page_buttons as $button) {
            array_push($page_buttons, array(
                'title'             => $button->title,
                'next_page_id'      => $button->next_page->id,
                'vue_router_name'   => $button->vue_router_name,
            ));
        }

        $page_composer = [];
        foreach ($this->page->page_composer as $item) {
            if ($item->type == 'pc_text') {
                array_push($page_composer, array(
                    'type' => $item->type,
                    'body' => $item->body,
                ));
            }
            if ($item->type == 'pc_accordion') {
                $acc = [];
                foreach($item->accordion as $ac_item) {
                    array_push($acc, array(
                        'title' => $ac_item->title,
                        'body' => $ac_item->body,
                    ));
                }
                array_push($page_composer, array(
                    'type' => $item->type,
                    'accordion' => $acc,
                ));
            }
            if ($item->type == 'pc_arrow_button') {
                array_push($page_composer, array(
                    'type' => $item->type,
                    'title' => $item->title,
                    'page' => array(
                        'page_id' => $item->next_page->id,
                        'template' => $item->next_page->template->name
                    )
                ));
            }
            if ($item->type == 'pc_button') {
                array_push($page_composer, array(
                    'type' => $item->type,
                    'title' => $item->title,
                    'page' => array(
                        'page_id' => $item->next_page->id,
                        'template' => $item->next_page->template->name
                    )
                ));
            }

        }

        return json_encode([
            'title' => $this->page->title,
            'body' => $this->page->body,
            'accordion' => $accordion,
            'page_buttons' => $page_buttons,
            'next_page' => $this->page->next_page->id,
            'vue_router_name' => $this->page->vue_router_name,
            'button_type' => $this->page->button_type,
            'button_name' => $this->page->button_name,
            'template' => $this->page->template->name,
            'page_composer' => $page_composer
        ]);
    }
}

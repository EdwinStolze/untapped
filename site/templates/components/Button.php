<?php

namespace Wireframe\Component;

/**
 * Card component
 */
class Button extends \Wireframe\Component {

    /**
     * Constructor method
     *
     * @param \ProcessWire\Page $item Page related to current Card.
     * @param string|null $title Optional card title, overrides page title.
     * @param string|null $url Optional card summary, overrides page url.
     */
    public function __construct(\ProcessWire\Page $item, ?string $url = null, ?string $title = null) {

        // Pass properties to view
        $this->title = $title ?: $item->title;
        $this->url = $url ?: $item->url;
        // $this->item = $item;
    }

}
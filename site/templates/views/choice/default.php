<?php namespace ProcessWire; ?>
<div class="inner">
    <?php foreach($page->children() as $child) : ?>
        <a href="<?= $child->url ?>" class="main-nav-button">
            <span class="title h1">
                <?= $child->title ?> 
            </span>
            <div class="button-circle">
                <?= file_get_contents(__DIR__ . '../../../resources/arrow.svg') ?>
            </div>
        </a>
    <?php endforeach ; ?>
</div>


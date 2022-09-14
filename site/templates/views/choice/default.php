<?php namespace ProcessWire; ?>
<div class="inner">
    <?php foreach($page->children() as $child) : ?>
        <a href="" class="main-nav-button">
            <span class="title h1">
                <?= $child->title ?> 
            </span>
            <div class="button-circle">
                <?= file_get_contents(__DIR__ . '../../resources/arrow.svg') ?>
            </div>
        </a>
    <?php endforeach ; ?>
</div>
<footer class="footer">
    <?php echo  Wireframe::component('Button', [$page, $nextPage->url])->setView('default'); ?>
</footer>

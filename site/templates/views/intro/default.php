<?php namespace ProcessWire; ?>
    <div class="inner">
        <?= $page->body ?>
    </div>
    <footer class="footer">
        <?php echo  Wireframe::component('Button', [$page, $nextPage->url])->setView('default'); ?>
    </footer>

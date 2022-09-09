<!doctype html>
<html lang="<?= $lang ?>">
    <head>
        <title><?= $page->title ?> | <?= $this->site_name ?></title>
        <link rel="stylesheet" href="<?= $config->urls->templates ?>styles/main.css">
        <script src="https://unpkg.com/vue@3"></script>
    </head>
    <body>
        <main class="main">
            <h1>untapped</h1>
        </main>
        <?= $placeholders->default ?>
    </body>
</html>
<!doctype html>
<html lang="<?= $lang ?>">
    <head>

    <meta charset="utf-8">
        <title><?= $page->title ?> | <?= $this->site_name ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.typekit.net/nnq4ois.css">
        <link rel="stylesheet" href="<?= $config->urls->templates ?>styles/main.css">
        <script src="https://unpkg.com/vue@3"></script>
    </head>
    <body>
        <main class="main container">
            <div class="topbar">
                <h1>untapped</h1>
            </div>
            <div class="grid ">
                <?= $placeholders->default ?>
            </div>
        </main>
    </body>
</html>
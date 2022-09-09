<!doctype html>
<html lang="<?= $lang ?>">
    <head>
        <title><?= $page->title ?> | <?= $this->site_name ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= $config->urls->templates ?>styles/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/css/foundation.min.css" crossorigin="anonymous">
        <script src="https://unpkg.com/vue@3"></script>

        <style>
            button {
                background-color: gray ;
                padding: .5em;
                border: none;
                margin: 0 2px;
                border-radius: 0.2em;
            }
            button.red {
                background-color: red;
            }
            button.orange {
                background-color: orange;
            }
            button.active  {
                background-color: green;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <main class="main">
                <div class="topbar">
                    <!-- <h1>Skills <span>untapped</span></h1> -->
                </div>
            </main>
            <div id="app">
                <div class="grid">
                    <div class="question">
                        <p>Is life more fun when working for McDonalds?</p>
                    </div>
                    <div class="progressNOT">
                        <app-button>Click me</app-button>      
                        <app-button type="error"></app-button>      
                    </div>
                    <div class="score">
                    </div>
                    <div class="explanation">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus mollitia recusandae, explicabo velit, dolorum reiciendis vel asperiores accusamus quidem, laboriosam illo. Facilis commodi laudantium, minima dolorem repellat voluptate id dignissimos libero fugiat sit impedit, placeat numquam nemo, consectetur fuga veniam. Soluta necessitatibus natus consequatur facere vitae, reiciendis nisi quia nostrum?</p>
                    </div>
                    <ul>
                        <li v-for="question in questions" :key="question.id">
                            <label>
                                {{ question.question }}
                                <input type="checkbox" v-model="question.complete">
                            </label>
                        </li>
                    </ul>
                    <div class="navigate">
                        <input type="range" min="1" max="5" step="1" v-model="answer" >
                    </div>
                    <pre>
                        {{ answer }}
                    </pre>
                </div>
            </div>
        </div>
        <!-- <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/js/foundation.min.js" crossorigin="anonymous"></script> -->
        <script type="module">
            import App from '/src/js/components/App.js';
            Vue.createApp(App).mount('#app');
        </script>
    </body>
</html>
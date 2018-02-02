let mix = require('laravel-mix');

mix.js('resources/assets/js/bootstrap.js', 'public/js/bootstrap.js')
    .js('resources/assets/js/threads/app.js', 'public/js/threads.js')
    .js('resources/assets/js/replies/app.js', 'public/js/replies.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .extract(['vue']);

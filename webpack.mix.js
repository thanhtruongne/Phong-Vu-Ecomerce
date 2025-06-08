const mix = require('laravel-mix');
require('laravel-mix-merge-manifest')
mix.mergeManifest();






mix.js('resources/js/main.jsx', 'public/js')
    .react()
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .sass('resources/sass/app.scss', 'public/css')
    .version();

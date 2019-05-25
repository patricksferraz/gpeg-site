const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Assets Default
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

// Css
mix.styles(['resources/assets/css/bootstrap.min.css',
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/fonts-google.css',
    'resources/assets/css/estilo.css'], 'public/css/all.css');

// Js
mix.js(['resources/assets/js/jquery-3.3.1.min.js',
    'resources/assets/js/jquery.base64.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/init.js',
    'resources/assets/js/controller.js',
    'resources/assets/js/tableExport.js'], 'public/js/all.js');

// Icon
mix.copy('resources/assets/img/icons/favicon.ico', 'public/favicon.ico')

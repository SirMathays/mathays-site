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

mix.setPublicPath('../public_html')
    .js('resources/js/app.js', 'js')
    .js('resources/js/admin.js', 'js')
    .js('resources/js/personal.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .sass('resources/sass/admin.scss', 'css')
    .sass('resources/sass/personal.scss', 'css')
    .version();

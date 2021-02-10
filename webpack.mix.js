let mix = require('laravel-mix');

mix.setPublicPath('dist')
    .js('resources/js/qviewer.js', 'js')
    .sass('resources/sass/qviewer.scss', 'css')
    .js('resources/js/card.js', 'js')
    .sass('resources/sass/card.scss', 'css')
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
    .js('resources/js/editor.js', 'js')
    .sass('resources/sass/editor.scss', 'css')
    .js('resources/js/shuazi.js', 'js')
    .sass('resources/sass/shuazi.scss', 'css');

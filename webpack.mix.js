let mix = require('laravel-mix');

mix.setPublicPath('assets');
mix.setResourceRoot('../');
mix
    .js('src/js/boot.js', 'assets/js/boot.js')
    .js('src/js/main.js', 'assets/admin/js/plugin_one.js')
    .sass('src/scss/admin/app.scss', 'assets/admin/css/plugin_one.css')
    


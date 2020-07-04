let mix = require('laravel-mix');

mix.setPublicPath('assets');
mix.setResourceRoot('../');
mix
    .js('src/js/main.js', 'assets/admin/js/plugin-one-admin.js')
    .js('src/js/card-main.js', 'assets/admin/js/plugin-one-card-admin.js')
    .sass('src/scss/admin/app.scss', 'assets/admin/css/plugin-one-admin.css')
    .sass('src/scss/card-public.scss', 'assets/public/css/plugin-one-card-public.css')

    mix.options({
        processCssUrls: false,
});





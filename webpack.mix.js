const mix = require('laravel-mix');
require('laravel-mix-copy-watched');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath('./dist')
    .browserSync({
        proxy: "https://local.mammarzenie.org",
        https: {
            key: '/Users/rafflex/.config/valet/Certificates/localhost.key',
            cert: '/Users/rafflex/.config/valet/Certificates/localhost.crt'
        },
        files: [
            "./assets/scripts/**/*.js",
            "./assets/styles/**/*.scss"
        ]
    });

mix
    .sass('assets/styles/admin.scss', 'dist/styles')
    .sass('assets/styles/front.scss', 'dist/styles');

mix
    .js('assets/scripts/admin.js', 'dist/scripts');

mix
    .copyWatched('assets/images/**', 'dist/images')
    .copyWatched('assets/svg/**', 'dist/svg')
    .copyWatched('assets/fonts/**', 'dist/fonts');

mix
    .autoload({ jquery: ['$', 'window.jQuery'] })
    .sourceMaps(false, 'source-map')
    .version();
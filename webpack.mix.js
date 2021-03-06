const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .styles(['./node_modules/primevue/resources/themes/saga-blue/theme.css',
        './node_modules/primevue/resources/primevue.min.css',
     './node_modules/primeicons/primeicons.css'], 'public/css/dist.css')
    .copyDirectory('./node_modules/primeicons/fonts', 'public/css/fonts')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}

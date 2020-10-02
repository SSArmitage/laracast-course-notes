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

// takes in 2 arguments => an entry point & an output directory
// everything in entry point will be compied to public directory (as part of build process using webpack)
// js compilation => in the js entry point can pull in a view, require modules, etc
// can change js() and sass() to less() or react() or combine() to combine some files...
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


// Webpack is an open-source JavaScript module bundler. It is made primarily for JavaScript, but it can transform front-end assets like HTML, CSS, and images if the corresponding loaders are included. webpack takes modules with dependencies and generates static assets representing those modules
// At its core, webpack is a static module bundler for modern JavaScript applications. When webpack processes your application, it internally builds a dependency graph which maps every module your project needs and generates one or more bundles
// Learn more here=> https://webpack.js.org/concepts/
// laravel comes with webpack support out of the box, but on top of that it comes with laravel mix (like a wrapper around webpack to make common steps easy to accomplish)...

// Laravel Mix
// asset pipeline tool 

// for any new project:
// 1. run npm install *** Need to npm install dependencies *** (can see dependencies in package.json)
// 2. configure mix() in webpack.mix.js to choose what to compile
// 3. compile using "npm run dev" OR "nom run watch"
// npm run dev => everytime you made a change in css or js would have to run npm dev let it compile and then reload the browser
// run npm run watch => will keep an eye on the sass and js files for changes to compile and will automatically do that for you
// when done working (no more css or js changes), hit control + c to stop watching
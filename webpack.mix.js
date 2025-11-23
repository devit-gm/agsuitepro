const mix = require('laravel-mix');
const glob = require('glob');

mix.js('resources/js/app.js', 'public/js')
   .copyDirectory('resources/images', 'public/images');

   const sassFiles = glob.sync('resources/sass/*.scss');

sassFiles.forEach((file) => {
    mix.sass(file, 'public/css');
});
   

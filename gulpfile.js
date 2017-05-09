const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss');
    mix.copy('resources/assets/vendor/bootstrap/fonts', 'public/fonts');
    mix.copy('resources/assets/vendor/font-awesome/fonts', 'public/fonts')
    mix.styles([
        'resources/assets/vendor/bootstrap/css/bootstrap.css',
        'resources/assets/vendor/animate/animate.css',
        'resources/assets/vendor/style/style.css',
        'resources/assets/vendor/font-awesome/css/font-awesome.css',
        'resources/assets/vendor/DataTables/css/dataTables.bootstrap.min.css',
        'resources/assets/vendor/toastr/css/toastr.min.css',
    ], 'public/css/vendor.css', './');
    mix.scripts([
        'resources/assets/vendor/jquery/jquery-3.1.1.min.js',
        'resources/assets/vendor/bootstrap/js/bootstrap.js',
         'resources/assets/vendor/validate/jquery.validate.min.js',
        'resources/assets/vendor/DataTables/js/jquery.dataTables.min.js',
        'resources/assets/vendor/DataTables/js/dataTables.bootstrap.min.js',
        'resources/assets/vendor/metisMenu/jquery.metisMenu.js',
        'resources/assets/vendor/toastr/js/toastr.min.js',
        'resources/assets/vendor/slimscroll/jquery.slimscroll.min.js',
        'resources/assets/js/app.js'
    ], 'public/js/app.js', './');

});

let Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .createSharedEntry('layout', './assets/js/layout.js')
    .addEntry('js/app', './assets/js/app/app.js')
    .addEntry('js/appMap', './assets/js/app/appMap.js')
    .addEntry('js/appFancybox', './assets/js/app/appFancybox.js')
    .addStyleEntry('css/tyres/show_tyres', './assets/css/tyres/show_tyres.css')
    .cleanupOutputBeforeBuild()
    // .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();


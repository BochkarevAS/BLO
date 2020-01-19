let Encore = require('@symfony/webpack-encore');
let CopyWebpackPlugin = require('copy-webpack-plugin');

let path = require('path');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    // .createSharedEntry('layout', './assets/src/layout.src')

    .addEntry('index', './assets/src/index.js')

    .addStyleEntry('css/style', './assets/css/style.css')

    // will require an extra script tag for runtime.src
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .autoProvidejQuery()
    .enableReactPreset()

    // enables @babel/preset-env polyfills
    .configureBabel((babelConfig) => {
        babelConfig.plugins.push('@babel/plugin-proposal-class-properties');
        babelConfig.presets.push('@babel/preset-flow');
        // babelConfig.plugins.push('@babel/plugin-proposal-async-generator-functions');
        // babelConfig.presets.push('@babel/preset-es2017');
    }, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // IMAGES
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images', force: true }
    ]))

    .copyFiles([
        {from: './node_modules/ckeditor/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
        {from: './node_modules/ckeditor/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]'}
    ])
;
let config = Encore.getWebpackConfig();

config.resolve = {
    extensions: [".jsx", ".js"],
    alias: {
        'load-image': 'blueimp-load-image/js/load-image.js',
        'load-image-meta': 'blueimp-load-image/js/load-image-meta.js',
        'load-image-exif': 'blueimp-load-image/js/load-image-exif.js',
        'load-image-scale': 'blueimp-load-image/js/load-image-scale.js',
        'canvas-to-blob': 'blueimp-canvas-to-blob/js/canvas-to-blob.js',
        'jquery-ui/ui/widget': 'blueimp-file-upload/js/vendor/jquery.ui.widget.js'
    }
};

module.exports = config;
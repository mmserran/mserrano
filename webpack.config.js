const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = function (env, argv) {
    var production = (argv.mode === 'production');
    var config = {
        entry: {
            vendor: './frontend/build/vendor.js',
            lab: './frontend/build/entry.js',
        },
        output: {
            filename: './public/[name].mserrano.js',
            path: path.resolve(__dirname)
        },
        module: {
            rules: [
                {test: /\.(js)$/, loader: 'ng-annotate-loader'},
                {test: /\.(html)$/, loader: 'angular-templatecache-loader?module=lab'},
                {test: /\.(scss)$/, loader: ExtractTextPlugin.extract(['css-loader', 'sass-loader'])},
            ],
        },
        plugins: [
            new ExtractTextPlugin('./public/lab.mserrano.css'),
        ],
    };

    if (production === false) {
        config.devtool = 'inline-source-map';
    }
    return config;
};
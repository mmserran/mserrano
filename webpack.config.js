const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = function (env, argv) {
    var app_name = 'lab'; //APP_NAME
    var production = (argv.mode === 'production');
    var config = {
        entry: {
            [app_name]: './frontend/build/entry.js',
            vendor: './frontend/build/vendor.js',
            template: './frontend/build/template.js',
        },
        output: {
            filename: './public/[name].mserrano.js',
            path: path.resolve(__dirname)
        },
        module: {
            rules: [
                {test: /\.(js)$/, loader: 'ng-annotate-loader'},
                {test: /\.(html)$/, loader: 'angular-templatecache-loader?module=' + app_name},
                {test: /\.(scss)$/, loader: ExtractTextPlugin.extract([
                        {
                            loader: 'css-loader'
                        },
                        {
                            loader: 'sass-loader',
                            options: {includePaths: [path.resolve(__dirname, "./library/styles")]}
                        }
                    ])},
            ],
        },
        plugins: [
            new ExtractTextPlugin('./public/lab.mserrano.css'),
        ],
    };

    if (production === false) {
        config.devtool = 'inline-cheap-source-map';
    }
    return config;
};
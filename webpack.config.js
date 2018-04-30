const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = function (env, argv) {
    var app_name = 'lab';
    var production = (argv.mode === 'production');
    var config = {
        entry: {},
        output: {
            filename: './public/[name].mserrano.js',
            path: path.resolve(__dirname)
        },
        module: {
            rules: [
                {test: /\.(js)$/, loader: 'ng-annotate-loader'},
                {test: /\.(html)$/, loader: 'angular-templatecache-loader?module=' + app_name},
                {test: /\.(scss)$/, loader: ExtractTextPlugin.extract(['css-loader', 'sass-loader'])},
            ],
        },
        plugins: [
            new ExtractTextPlugin('./public/lab.mserrano.css'),
        ],
    };
    config.entry[app_name] = './frontend/build/entry.js';
    config.entry.vendor = './frontend/build/vendor.js';
    config.entry.template = './frontend/build/template.js';

    if (production === false) {
        config.devtool = 'inline-cheap-source-map';
    }
    return config;
};
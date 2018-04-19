const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

const config = {
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
            {test: /\.(scss)$/, loader: ExtractTextPlugin.extract(['css-loader', 'sass-loader'])},
            {test: /\.(html)$/, loader: 'html-loader'}
        ]
    },
    plugins: [
        new ExtractTextPlugin('./public/lab.mserrano.css')
    ]
};

module.exports = config;
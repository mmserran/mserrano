const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

const config = {
    entry: './frontend/build/entry.js',
    output: {
        filename: './public/lab.mserrano.js',
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

if (process.env.NODE_ENV === 'production') {
    config.plugins.push(new webpack.optimize.UglifyJsPlugin({
        comments: false
    }));
}

module.exports = config;
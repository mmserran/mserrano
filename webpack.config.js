const path = require('path');
const webpack = require('webpack');

const config = {
    entry: './frontend/build/entry.js',
    output: {
        filename: './public/lab.mserrano.js',
        path: path.resolve(__dirname)
    },
    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            comments: false
        })
    ]
};

module.exports = config;
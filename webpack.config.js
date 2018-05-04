const path = require("path");
const webpack = require("webpack");
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = (env, argv) => {
    const app_name = "lab"; //APP_NAME
    const production = (argv.mode === "production");

    let config = {
        entry: {
            [app_name]: "./frontend/build/entry.js",
            vendor: "./frontend/build/vendor.js",
            styles: "./frontend/build/styles.js",
            template: './frontend/build/template.js',
        },
        output: {
            filename: (arg) => {
                const blacklist = ["template", "styles"];
                const is_scratch = (blacklist.indexOf(arg.chunk.name) !== -1);

                return (is_scratch === true ? "./tmp/trash/[name].scratch" : "./public/[name].mserrano.js");
            },
            path: path.resolve(__dirname),
        },
        module: {
            rules: [
                {test: /\.(js)$/, loader: "ng-annotate-loader"},
                {test: /\.(html)$/, loader: "angular-templatecache-loader?module=" + app_name},
                {test: /\.(scss)$/, loader: ExtractTextPlugin.extract([
                        {
                            loader: "css-loader"
                        },
                        {
                            loader: "sass-loader",
                            options: {includePaths: [path.resolve(__dirname, "./library/styles")]}
                        }
                    ])},
            ],
        },
        plugins: [
            new ExtractTextPlugin("./public/lab.mserrano.css"),
        ],
    };

    if (production === false) {
        config.devtool = "inline-cheap-source-map";
    }
    return config;
};
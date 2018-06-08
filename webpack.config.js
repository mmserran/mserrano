const path = require("path");
const webpack = require("webpack");
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = (env, argv) => {
    const app_name = "lab"; //APP_NAME
    const production = (argv.mode === "production");

    const extract_src_styles = new ExtractTextPlugin("./public/" + app_name + ".mserrano.css");
    const extract_vendor_styles = new ExtractTextPlugin("./public/vendor.mserrano.css");
    const extract_unittest_styles = new ExtractTextPlugin("./tmp/sass-output-report/sass-true.output.css");

    const css_loader = {loader: "css-loader",
        options: {
            minimize: (production === true)}};
    const scss_loader = {loader: "sass-loader",
        options: {
            includePaths: [path.resolve(__dirname, "./library/styles")],
            outputStyle: (production === true ? 'compressed' : 'nested')}};
    const postcss_loader = {loader: "postcss-loader",
        options: {
            plugins: (loader) => [
                    require('autoprefixer')(),
                    require('postcss-discard-comments')({removeAll: true}),
                ]}};
    const spec_scss_loader = {loader: "sass-loader",
        options: {includePaths: [
                path.resolve(__dirname, "./library/styles"),
                path.resolve(__dirname, "./frontend/tests/styles"),
                path.resolve(__dirname, "./node_modules/sass-true/sass")]}}

    let config = {
        entry: {
            [app_name]: "./frontend/build/entry.js",
            vendor: "./frontend/build/vendor.js",
            styles: "./frontend/build/styles.js",
            template: './frontend/build/template.js',
            sassTrue: './frontend/tests/sass-true.output.js',
        },
        output: {
            filename: (arg) => {
                const blacklist = ["template", "styles", "sassTrue"];
                const is_scratch = (blacklist.indexOf(arg.chunk.name) !== -1);

                return (is_scratch === true ? "./tmp/trash/[name].scratch" : "./public/[name].mserrano.js");
            },
            path: path.resolve(__dirname),
        },
        module: {
            rules: [
                {test: /\.(js)$/, loader: "ng-annotate-loader"},
                {test: /\.(html)$/, loader: "angular-templatecache-loader?module=" + app_name},
                {test: /\.(scss)$/,
                    include: [path.resolve(__dirname, "./frontend/src"), path.resolve(__dirname, "./library/styles")],
                    use: extract_src_styles.extract([css_loader, postcss_loader, scss_loader])},
                {test: /\.(scss)$/,
                    include: [path.resolve(__dirname, "./library/javascript")],
                    use: extract_vendor_styles.extract([css_loader, scss_loader])},
                {test: /\.spec\.scss$/,
                    use: extract_unittest_styles.extract([css_loader, spec_scss_loader])},
            ],
        },
        plugins: [
            extract_src_styles,
            extract_vendor_styles,
            extract_unittest_styles,
        ],
    };

    if (production === false) {
        config.devtool = "inline-cheap-source-map";
    }
    return config;
};
module.exports = function (config) {
    config.set({
        basePath: '../..',
        frameworks: ['jasmine'],
        files: [
            'public/vendor.mserrano.js',
            'library/javascript/angular-mocks.js',
            'public/lab.mserrano.js',
            'frontend/tests/helpers/helpers.*.js',
            'frontend/tests/src/*.spec.js',
        ],
        browsers: ['PhantomJS'],
        reporters: ['dots'],
    });
};
angular.module("lab.blocks")
        .config(function ($translateProvider) {
            $translateProvider.useSanitizeValueStrategy('sanitize');
            $translateProvider
                    .preferredLanguage("en");
        });
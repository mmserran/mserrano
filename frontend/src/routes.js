module.exports = angular.module("lab.routing")
        .config(["$routeProvider",
            function ($routeProvider) {
                $routeProvider.when('/', {
                    template: require('../src/pages/landing/landing.html'),
                    controller: require('../src/pages/landing/LandingCtrl.js'),
                    controllerAs: 'page',
                });
                $routeProvider.when('/sitedown', {
                    template: require('../src/pages/sitedown/sitedown.html'),
                    controller: require('../src/pages/sitedown/SiteDownCtrl.js'),
                    controllerAs: 'page',
                });

                $routeProvider.otherwise({redirectTo: '/'});
            }]);
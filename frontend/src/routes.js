angular.module("lab.routing")
        .config(["$routeProvider",
            function ($routeProvider) {
                $routeProvider.when('/', {
                    template: require('./pages/landing/landing.html'),
                    controller: require('./pages/landing/LandingCtrl.js'),
                    controllerAs: 'page',
                });
                $routeProvider.when('/sitedown', {
                    template: require('./pages/sitedown/sitedown.html'),
                    controller: require('./pages/sitedown/SiteDownCtrl.js'),
                    controllerAs: 'page',
                });

                $routeProvider.otherwise({redirectTo: '/'});
            }]);
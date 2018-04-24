angular.module("lab.routing")
        .config(["$routeProvider",
            function ($routeProvider) {
                $routeProvider.when('/', {
                    template: require('./pages/landing/landing.html'),
                    controller: 'LandingCtrl',
                    controllerAs: 'page',
                });
                $routeProvider.when('/sitedown', {
                    template: require('./pages/sitedown/sitedown.html'),
                    controller: 'SiteDownCtrl',
                    controllerAs: 'page',
                });

                $routeProvider.otherwise({redirectTo: '/'});
            }]);
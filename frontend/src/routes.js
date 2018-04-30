angular.module("lab.routing")
        .config(function ($routeProvider) {
            $routeProvider.when('/', {
                templateUrl: 'frontend/src/pages/landing/landing.html',
                controller: 'LandingCtrl',
                controllerAs: 'page',
            });
            $routeProvider.when('/sitedown', {
                templateUrl: 'frontend/src/pages/sitedown/sitedown.html',
                controller: 'SiteDownCtrl',
                controllerAs: 'page',
            });

            $routeProvider.otherwise({redirectTo: '/'});
        });
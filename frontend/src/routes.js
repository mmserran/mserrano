module.exports = angular.module("lab.routing")
        .config(["$routeProvider",
            function ($routeProvider) {
                $routeProvider.when('/', {
                    template: '<div>AngularJS</div>',
                    controller: require('../src/pages/landing/LandingCtrl.js'),
                });
                $routeProvider.when('/sitedown', {
                    template: '<div>Angular</div>',
                    controller: require('../src/pages/sitedown/SiteDownCtrl.js'),
                });

                $routeProvider.otherwise({redirectTo: '/'});
            }]);
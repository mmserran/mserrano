angular.module("lab.routes")
        .config(["$routeProvider", function ($routeProvider) {
                console.log('wat')
                $routeProvider
                        .when('/', {
                            controller: 'LandingCtrl'
                        })
            }]);
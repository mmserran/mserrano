angular.module("lab.controllers")
        .controller("SiteDownCtrl", module.exports);

module.exports = ["Const", "$scope", "$http", "Request", function (Const, $scope, $http, Request) {
        var _this = this;
        _this.sitedown = "Sitedown 1 " + Const.Default.Date;
        
        var request = new Request.cached(function () {
            var get = {}, post = {};
            var config = {
                method: 'GET',
                url: '/lab_constants',
                params: get,
                data: post,
            };

            return $http(config);
        });

        request.call().then(function () {
            var res = request.get_data("Default")
            console.log(res);
        });
        request.call().then(function () {
            var res = request.get_data("Default")
            console.log(res);
        });

        $scope.sitedown2 = "Sitedown 2";
    }];
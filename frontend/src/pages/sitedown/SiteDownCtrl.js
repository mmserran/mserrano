angular.module("lab.controllers")
        .controller("SiteDownCtrl", module.exports);

module.exports = ["$scope", function ($scope) {
    var _this = this;
    _this.sitedown = "Sitedown 1";
    
    $scope.sitedown2 = "Sitedown 2";
}];
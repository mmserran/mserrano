angular.module("lab.controllers")
        .controller("SiteDownCtrl", function (Const, Midtier) {
                var _this = this;
                _this.sitedown = "Sitedown 1 " + Const.Default.Date;

                Midtier.lab_constants.call().then(function () {
                    var res = Midtier.lab_constants.get_data("Default")
                    console.log(res);
                });
                Midtier.checker.call().then(function () {
                    console.log('hello world');
                });
            });
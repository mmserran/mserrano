describe("!! routes.js !! ", function () {
    "use strict";

    var $route, $controller;
    beforeEach(function () {
        module("lab");

        inject(function (_$route_, _$controller_) {
            $route = _$route_;
            $controller = _$controller_;
        });
    });

    // setUp
    var rnd;
    beforeEach(function () {
        rnd = helper.number.rand();
    });

    // tearDown
    var obj;
    afterEach(function () {
        obj = null;
    });

    it("should exist", function () {
        expect($route).toBeDefined();
    });

    describe("routes", function () {
        describe("landing", function () {
            var path = '/';
            beforeEach(function () {
                obj = $route.routes[path];
            });

            it("is not defined", function () {
                var err_msg = "Expected route \'" + path + "\' to be defined";
                expect(obj).toBeDefined(err_msg);
            });

            it("invalid template", function () {
                expect(obj.template).toEqual(jasmine.any(String));
            });

            it("invalid controller", function () {
                expect(obj.controller).toEqual(jasmine.any(String));
            });
        });

        describe("sitedown", function () {
            var path = '/sitedown';
            beforeEach(function () {
                obj = $route.routes[path];
            });

            it("is not defined", function () {
                var err_msg = "Expected route \'" + path + "\' to be defined";
                expect(obj).toBeDefined(err_msg);
            });

            it("invalid template", function () {
                expect(obj.template).toEqual(jasmine.any(String));
            });

            it("invalid controller", function () {
                expect(obj.controller).toEqual(jasmine.any(String));
            });
        });
    });
});
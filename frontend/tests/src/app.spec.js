describe("!! app.js !! ", function () {
    "use strict";

    beforeEach(function () {
        module("lab"); // bootstrap angular
    });

    // setUp
    var rnd;
    beforeEach(function () {
        rnd = helper.number.rand();
    });

    // teardown
    var obj;
    afterEach(function () {
        obj = null;
    });

    it("should exist", function () {
        helper.expect.module_to_exist("lab");
    });

    describe("module", function () {
        beforeEach(function () {
            obj = angular.module("lab");
        });

        describe("lab.routing", function () {
            it("is not in the dependency list", function () {
                helper.expect.in_array("lab.routing", obj.requires);
            });

            it("not instantiated", function () {
                helper.expect.module_to_exist("lab.routing");
            });

            it("is missing ngRoute", function () {
                obj = angular.module("lab.routing");
                helper.expect.in_array("ngRoute", obj.requires);
            });
        });

        describe("lab.constants", function () {
            it("is not in the dependency list", function () {
                helper.expect.in_array("lab.constants", obj.requires);
            });

            it("not instantiated", function () {
                helper.expect.module_to_exist("lab.constants");
            });
        });

        describe("lab.controllers", function () {
            it("is not in the dependency list", function () {
                helper.expect.in_array("lab.controllers", obj.requires);
            });

            it("not instantiated", function () {
                helper.expect.module_to_exist("lab.controllers");
            });
        });
    });
});
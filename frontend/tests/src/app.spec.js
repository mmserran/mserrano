describe("!! app.js !! ", function () {
    "use strict";

    // setUp - constants
    beforeEach(function () {
        helper.test.setUp({});
    });

    // setUp - test case
    var rnd;
    beforeEach(function () {
        rnd = helper.number.rand();
    });

    // teardown
    var obj;
    afterEach(function () {
        obj = null;

        helper.test.tearDown();
    });

    it("should exist", function () {
        helper.expect.module_to_exist("lab");
    });

    describe("module", function () {
        beforeEach(function () {
            obj = angular.module("lab");
        });

        describe("lab.routing", function () {
            it("should be in dependency list", function () {
                helper.expect.in_array("lab.routing", obj.requires);
            });

            it("should be instantiated", function () {
                helper.expect.module_to_exist("lab.routing");
            });

            it("should use ngRoute", function () {
                obj = angular.module("lab.routing");
                helper.expect.in_array("ngRoute", obj.requires);
            });
        });

        describe("lab.constants", function () {
            it("should be in dependency list", function () {
                helper.expect.in_array("lab.constants", obj.requires);
            });

            it("should be instantiated", function () {
                helper.expect.module_to_exist("lab.constants");
            });
        });

        describe("lab.controllers", function () {
            it("should be in dependency list", function () {
                helper.expect.in_array("lab.controllers", obj.requires);
            });

            it("should be instantiated", function () {
                helper.expect.module_to_exist("lab.controllers");
            });
        });

        describe("lab.services", function () {
            it("should be in dependency list", function () {
                helper.expect.in_array("lab.services", obj.requires);
            });

            it("should be instantiated", function () {
                helper.expect.module_to_exist("lab.services");
            });
        });
    });
});
"use strict";

(function () {
    window.helper = (window.helper || {});
    window.helper.expect = (window.helper.expect || {});

    // -- Functions -- //
    window.helper.expect.module_to_exist = expect_module_to_exist;
    window.helper.expect.in_array = expect_in_array;

    // -- Helpers -- //
    function expect_module_to_exist(name) {
        var obj = angular.module(name);
        expect(obj).toBeDefined();
    }
    function expect_in_array(needle, haystack) {
        var err_msg = "expected " + angular.toJson(needle) + " in " + angular.toJson(haystack);
        expect(haystack.indexOf(needle) === -1).toBe(false, err_msg);
    }
})();
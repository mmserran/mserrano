angular.module("lab", [
    "pascalprecht.translate",
    "ngSanitize",
    "ngMaterial",
    "ngAnimate",
    "ngAria",
    //
    "lab.blocks",
    "lab.constants",
    "lab.controllers",
    "lab.routing",
    "lab.services",
]);

angular.module("lab.blocks", []);
angular.module("lab.constants", []);
angular.module("lab.controllers", []);
angular.module("lab.routing", ["ngRoute"]);
angular.module("lab.services", []);
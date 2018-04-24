// test for javascript vendor files
var require_all = require.context('../../library/javascript', true, /.+\.js$/);
var list_vendor = require_all.keys();

// load AngularJS
var angularjs = list_vendor.splice(list_vendor.indexOf('./angular.js'), 1);
require_all(angularjs[0]);

// load all other vendor javascript
for (var i = 0; i < list_vendor.length; ++i) {
    var key = list_vendor[i];
    require_all(key);
}
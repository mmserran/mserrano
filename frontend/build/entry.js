// test for javascript source files
var require_all = require.context('../src/', true, /.+\.js$/);
var list_file = require_all.keys();

// load our app
var app = list_file.splice(list_file.indexOf('./app.js'), 1);
require_all(app[0]);

// load all other javascript in src directory
for (var i = 0; i < list_file.length; i++) {
    var key = list_file[i];
    require_all(key);
}
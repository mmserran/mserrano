// test for javascript/html/scss source files
var require_all = require.context('../src/', true, /.+\.(js|html|scss)$/);
var list_file = require_all.keys();

// load src directory
for (var i = 0; i < list_file.length; i++) {
    var key = list_file[i];
    require_all(key);
}
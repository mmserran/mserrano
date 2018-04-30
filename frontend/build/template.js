// test for html source files
var require_all = require.context('../src/', true, /.+\.(html)$/);
var list_file = require_all.keys();

// load all html in src directory
for (var i = 0; i < list_file.length; i++) {
    var key = list_file[i];
    require_all(key);
}
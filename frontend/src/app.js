module.exports = require('angular')
        .module("lab", [
            require("angular-route"),
            require("../build/controllers.js").name,
            require("../build/routing.js").name,
        ]);
!function(n){var t={};function e(l){if(t[l])return t[l].exports;var r=t[l]={i:l,l:!1,exports:{}};return n[l].call(r.exports,r,r.exports,e),r.l=!0,r.exports}e.m=n,e.c=t,e.d=function(n,t,l){e.o(n,t)||Object.defineProperty(n,t,{configurable:!1,enumerable:!0,get:l})},e.r=function(n){Object.defineProperty(n,"__esModule",{value:!0})},e.n=function(n){var t=n&&n.__esModule?function(){return n.default}:function(){return n};return e.d(t,"a",t),t},e.o=function(n,t){return Object.prototype.hasOwnProperty.call(n,t)},e.p="",e(e.s=9)}([function(n,t){angular.module("lab.services").service("Request",["Const",function(n){var t=[];return{cached:function(n){var a=t.length;t.push({promise:null,data:null}),this.is_valid=e.bind(null,t[a]),this.is_loaded=l.bind(null,t[a]),this.get_data=r.bind(null,t[a]),this.call=function(n,t){null===n.promise&&(n.promise=o.apply(null,arguments));return n.promise}.bind(null,t[a],n),this.clear_cache=function(n){n.promise=null}.bind(null,t[a])},standard:function(n){var a=t.length;t.push({promise:null,data:null}),this.is_valid=e.bind(null,t[a]),this.is_loaded=l.bind(null,t[a]),this.get_data=r.bind(null,t[a]),this.call=o.bind(null,t[a],n)}};function e(t){return t.data[n.Infrastructure.Result]!==n.Infrastructure.Fail}function l(n){return null!==n.data}function r(n,t){return n.data[t]}function o(n,t){var e=angular.extend([],arguments);return e.splice(0,2),t.apply(null,e).then(function(n,t){n.data=t.data}.bind(null,n))}}])},function(n,t){angular.module("lab.services").service("Midtier",["Const","$http","Request",function(n,t,e){return{lab_constants:new e.cached(function(){return t({method:"GET",url:"/lab_constants",params:{},data:{}})}),checker:new e.standard(function(){return t({method:"GET",url:"/checker",params:{},data:{}})})}}])},function(n,t){n.exports='<div>{{page.sitedown}}</div>\n<div ng-bind="sitedown2"></div>'},function(n,t){n.exports="<div>{{'Stick to the Plan'}}</div>"},function(n,t,e){angular.module("lab.routing").config(["$routeProvider",function(n){n.when("/",{template:e(3),controller:"LandingCtrl",controllerAs:"page"}),n.when("/sitedown",{template:e(2),controller:"SiteDownCtrl",controllerAs:"page"}),n.otherwise({redirectTo:"/"})}])},function(n,t){angular.module("lab.controllers").controller("SiteDownCtrl",["Const","Midtier",function(n,t){this.sitedown="Sitedown 1 "+n.Default.Date,t.lab_constants.call().then(function(){var n=t.lab_constants.get_data("Default");console.log(n)}),t.checker.call().then(function(){console.log("hello world")})}])},function(n,t){angular.module("lab.controllers").controller("LandingCtrl",["Const",function(n){console.log("hello, this is landing ctrl",n)}])},function(n,t){angular.module("lab",["lab.constants","lab.controllers","lab.routing","lab.services"]),angular.module("lab.constants",[]),angular.module("lab.controllers",[]),angular.module("lab.routing",["ngRoute"]),angular.module("lab.services",[])},function(n,t,e){var l={"./app.js":7,"./pages/landing/LandingCtrl.js":6,"./pages/sitedown/SiteDownCtrl.js":5,"./routes.js":4,"./services/app/Midtier.js":1,"./services/lab/Request.js":0};function r(n){var t=o(n);return e(t)}function o(n){var t=l[n];if(!(t+1)){var e=new Error('Cannot find module "'+n+'".');throw e.code="MODULE_NOT_FOUND",e}return t}r.keys=function(){return Object.keys(l)},r.resolve=o,n.exports=r,r.id=8},function(n,t,e){for(var l=e(8),r=l.keys(),o=0;o<r.length;o++){l(r[o])}}]);
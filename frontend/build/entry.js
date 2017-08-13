function component() {
    var element = document.createElement('div');

    element.innerHTML = 'hello webpack';

    console.log('hello bundle world')
    
    return element;
}
document.body.appendChild(component());

import '../vendor/angular.js';
import '../vendor/angular-route.js';

require('../src/app.js');
require('../src/routes.js');
require('../src/pages/landing/LandingCtrl.js');
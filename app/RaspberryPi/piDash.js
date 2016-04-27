'use strict';

angular.module('myApp.piDash', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/piDash', {
    templateUrl: 'RaspberryPi/piDash.html',
    controller: 'PiCtrl'
  });
}])

.controller('PiCtrl', [function() {

}]);
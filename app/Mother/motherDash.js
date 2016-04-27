'use strict';

angular.module('myApp.motherDash', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/motherDash', {
    templateUrl: 'Mother/motherDash.html',
    controller: 'MotherCtrl'
  });
}])

.controller('MotherCtrl', [function() {

}]);
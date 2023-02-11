'use strict';


// Declare app level module which depends on filters, and services
angular.module('rating', [ 
'ngRoute',
'tableSort',
'rating.filters',
'rating.directives',
'rating.controllers'
]).
config(['$routeProvider',function($routeProvider){

	$routeProvider.when('/gearscore/', {templateUrl : 'views/gearscore.html',controller : 'gearscore'});
	$routeProvider.when('/guilds/', {templateUrl : 'views/guilds.html', controller : 'guilds'});
	$routeProvider.when('/ships/', {templateUrl : 'views/ships.html', controller : 'ships'});
	$routeProvider.when('/arena/', {templateUrl : 'views/arena.html', controller : 'arena'});
	$routeProvider.when('/kills/', {templateUrl : 'views/kills.html', controller : 'kills'});
	
	$routeProvider.otherwise({redirectTo: '/gearscore'});

}]);
 
 
   
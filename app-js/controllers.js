'use strict';

/* Controllers */

angular.module('rating.controllers', [])

.controller('rating_selector', ['$scope','$location', function($scope,$location) {
		$scope.$on('$routeChangeSuccess', function(){
			var matches = /^\/(.*?)\//.exec($location.path());
			$scope.active = (matches != null)?matches[1]:'gearscore';
			if ($scope.active == 'alley') {
			   matches = /\/(\d.\d)\//.exec($location.path());
			   $scope.active = (matches != null)?matches[1]:$scope.active;
			}
		});
	}])

.controller('gearscore',['$scope','$http',function($scope, $http, $location){

	   $http.get("/top/api/gearscore.php").then(function (ratingData) {
	   var rating = ratingData.data;
	   $scope.data = ratingData.data.gearscore;
	   for (var i=0; i<$scope.data.length; i++) $scope.data[i].pos = i+1;
});

}])
.controller('guilds',['$scope','$http',function($scope, $http, $location){

	   $http.get("/top/api/guilds.php").then(function (ratingData) {
	   var rating = ratingData.data;
	   $scope.data = ratingData.data.guilds;
	   for (var i=0; i<$scope.data.length; i++) $scope.data[i].pos = i+1;
});
		   $scope.onSelectShard = function(){
			$location.path('/top/guilds/');
			return true;
		}
}])
.controller('ships',['$scope','$http',function($scope, $http, $location){

	   $http.get("/top/api/ships.php").then(function (ratingData) {
	   var rating = ratingData.data;
	   $scope.data = ratingData.data.ships;
	   for (var i=0; i<$scope.data.length; i++) $scope.data[i].pos = i+1;
}); 
			  $scope.onSelectShard = function(){
			$location.path('/top/ships/');
			return true;
		}
}])
.controller('arena',['$scope','$http',function($scope, $http, $location){

	   $http.get("/top/api/arena.php").then(function (ratingData) {
	   var rating = ratingData.data;
	   $scope.data = ratingData.data.arena;
	   for (var i=0; i<$scope.data.length; i++) $scope.data[i].pos = i+1;
}); 
			  $scope.onSelectShard = function(){
			$location.path('/top/arena/');
			return true;
		}
}])
.controller('kills',['$scope','$http',function($scope, $http, $location){

	   $http.get("/top/api/kills.php").then(function (ratingData) {
	   var rating = ratingData.data;
	   $scope.data = ratingData.data.kills;
	   for (var i=0; i<$scope.data.length; i++) $scope.data[i].pos = i+1;
}); 
			  $scope.onSelectShard = function(){
			$location.path('/top/kills/');
			return true;
		}
}]);



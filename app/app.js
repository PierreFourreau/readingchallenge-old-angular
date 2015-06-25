var app = angular.module('myApp', ['ngRoute']);
app.factory("services", ['$http', function($http) {
  var serviceBase = 'services/'
    var obj = {};
    obj.getCategories = function(){
        return $http.get(serviceBase + 'categories');
    }
    obj.getCategorie = function(categorieID){
        return $http.get(serviceBase + 'categorie?id=' + categorieID);
    }

    obj.insertCategorie = function (categorie) {
    return $http.post(serviceBase + 'insertCategorie', categorie).then(function (results) {
        return results;
    });
	};

	obj.updateCategorie = function (id,categorie) {
	    return $http.post(serviceBase + 'updateCategorie', {id:id, categorie:categorie}).then(function (status) {
	        return status.data;
	    });
	};

	obj.deleteCategorie = function (id) {
	    return $http.delete(serviceBase + 'deleteCategorie?id=' + id).then(function (status) {
	        return status.data;
	    });
	};

    return obj;   
}]);

app.controller('listCtrl', function ($scope, services) {
    services.getCategories().then(function(data){
        $scope.categories = data.data;
    });
});

app.controller('editCtrl', function ($scope, $rootScope, $location, $routeParams, services, categorie) {
    var categorieID = ($routeParams.categorieID) ? parseInt($routeParams.categorieID) : 0;
    $rootScope.title = (categorieID > 0) ? 'Edit categorie' : 'Add categorie';
    $scope.buttonText = (categorieID > 0) ? 'Update categorie' : 'Add New categorie';
      var original = categorie.data;
      original._id = categorieID;
      $scope.categorie = angular.copy(original);
      $scope.categorie._id = categorieID;

      $scope.isClean = function() {
        return angular.equals(original, $scope.categorie);
      }

      $scope.deleteCategorie = function(categorie) {
        $location.path('/');
        if(confirm("Are you sure to delete categorie number: "+$scope.categorie._id)==true)
        services.deleteCategorie(categorie.categorie_id);
      };

      $scope.saveCategorie = function(categorie) {
        $location.path('/');
        if (categorieID <= 0) {
            services.insertCategorie(categorie);
        }
        else {
            services.updateCategorie(categorieID, categorie);
        }
    };
});

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        title: 'Categories',
        templateUrl: 'partials/categories.html',
        controller: 'listCtrl'
      })
      .when('/edit-categorie/:categorieID', {
        title: 'Edit categories',
        templateUrl: 'partials/edit-categorie.html',
        controller: 'editCtrl',
        resolve: {
          categorie: function(services, $route){
            var categorieID = $route.current.params.categorieID;
            return services.getCategorie(categorieID);
          }
        }
      })
      .otherwise({
        redirectTo: '/'
      });
}]);
app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
}]);
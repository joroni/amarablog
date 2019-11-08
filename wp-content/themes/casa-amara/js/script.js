
var app = angular.module('myApp', []);

app.controller('myCtrl', function($scope, $http) {
 // $http.get("data/posts.json")

 $scope.theFilter = {};
 
 $scope.filterByCat1 = function(id) {
  // alert(id);
  $http.get("http://localhost/casaamarawp/wp-json/wp/v2/categories/"+id)
  .then(function(response) {
    var theCatPost = response.data;
    thisCatPost = JSON.stringify(theCatPost);
     var myCatPost = thisCatPost.replace(/<[^>]*>/g, '');
     $scope.myCatPosts = JSON.parse(myCatPost);
     console.log($scope.myCatPosts);
    return $scope.myCatPosts;
  });
};

 $scope.filterByCat = function(categories) {
  // alert(id);
   if ($scope.theFilter.categories === categories) {
     $scope.theFilter = {};
     console.log( $scope.theFilter );
   }
   else {
     $scope.theFilter.categories = categories;
     console.log( $scope.theFilter.categories );
   }
 };
 
  $http.get(" http://localhost/casaamarawp/wp-json/wp/v2/posts?filter_embed")
  .then(function(response) {
    var thePost = response.data;
    thisPost = JSON.stringify(thePost);
     var myPost = thisPost.replace(/<[^>]*>/g, '');
     $scope.myPosts = JSON.parse(myPost);
     console.log($scope.myPosts);
    return $scope.myPosts;
  });

  $http.get("http://localhost/casaamarawp/wp-json/wp/v2/categories")
  .then(function(response) {
    var theCategories = response.data;
    thisCategories = JSON.stringify(theCategories);
     var myCategories = thisCategories.replace(/<[^>]*>/g, '');
     $scope.myCategories = JSON.parse(myCategories);
     console.log($scope.myCategories);
    return $scope.myCategories;
  });

  $scope.Test = function($scope) {
    $scope.persons = [{type: 1, name: 'Caio'}, {type:2, name: 'Ary'}, {type:1, name: 'Cam'}, {type:3, name: 'Daniel'}];
      $scope.myFunction = function(val) {
      return (val.type != 2);
      };
  }


  
});



app.directive('onError', function() {  
  return {
    restrict:'A',
    link: function(scope, element, attr) {
      element.on('error', function() {
        element.attr('src', attr.onError);
      })
    }
  }
})
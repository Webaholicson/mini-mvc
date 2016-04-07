var bookSearchControllers = angular.module('bookSearchControllers', []);

bookSearchControllers.controller('BookSearchCtrl', ['$scope', '$http',
  function ($scope, $http) {
    $scope.results = [];

    $scope.showResults = false;

    $scope.resultMsg = '';

    $scope.books = [
      {
        'id': 'isbn-1',
        'name': 'isbn[]',
        'describedBy':'basic-addon1',
        'value': '',
        'canDelete': false
      }
    ];

    $scope.removeBook = function(book) {
      var index = $scope.books.indexOf(book);
      $scope.books.splice(index, 1);
    };

    $scope.getResults = function() {
      $http({
          method: 'POST',
          url: '/exercise-antonio/search',
          data: $.param($scope.books),
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' },
          responseType: 'json'
      }).success(function(data) {
        $scope.resultMsg = data.message
        if (data.success) {
          $scope.results = data['data'];
        }
        $scope.showResults = true;
      });
    };

    $scope.addBook = function() {
      $scope.books.push({
        'id': 'isbn-'+($scope.count+1),
        'name': 'isbn[]',
        'describedBy': 'basic-addon'+($scope.count+1),
        'canDelete': true
      });

      $scope.count += 1;
    };

    $scope.count = 1;
  }
]);

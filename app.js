var app = angular.module('SlideApp', []);

app.controller('SlideController', function ($scope, $http) {
    $scope.path = "/uploads/img.jpg";
    $http.get("/image.php?last=" + $scope.path).then(function (response) {
        $scope.path = response.data;
    });
});

var app = angular.module('SlideApp', []);

app.controller('PreviewController', function ($scope) {
    $scope.path = "/uploads/img.jpg";
});
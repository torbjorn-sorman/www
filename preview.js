var app = angular.module('PreviewApp', []);

app.controller('PreviewController', function ($scope, $http) {
    $scope.images = [];
    $http.get("/image.php?list=1" + $scope.path).then(function (response) {
        console.log(response.data);
        $scope.images = response.data;
    });
});
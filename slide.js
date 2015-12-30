var app = angular.module('SlideApp', []);

app.controller('SlideController', function ($scope, $http, $interval) {
    $scope.path = "/uploads/0.60032800.jpg";

    $interval(function () {
        $http.get("/image.php?last=" + $scope.path).then(function (response) {
            console.log(response.data);
            $scope.path = response.data;
        });
    }, 6000);
        
});
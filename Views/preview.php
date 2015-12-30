<html ng-app="PreviewApp">
<head>
    <title>Casino Royale Valla
    </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body ng-controller="PreviewController">

    <div class="block-overlay">
        <p class="golden-base golden3-overlay">Casino Royale Valla</p>
    </div>
    <div>
        <div ng-repeat="img in images">
            <a href="{{img}}">
                <img ng-src="{{img}}" class="thumb" /></a>
        </div>
    </div>
    <script type="text/javascript" src="angular.min.js"></script>
    <script type="text/javascript" src="preview.js"></script>
</body>
</html>

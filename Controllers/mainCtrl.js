app.controller('mainCtrl', function($scope){
   
    
    $.getJSON("http://46.101.170.107/all", function(data){
        $scope.latest = data.pages;
        $scope.$apply();
    });
    
    $scope.goToMood = function(mood){
        location.hash = "mood?id="+mood.id;
    }
});

app.controller('signInCtrl', function($scope, $element, $timeout){
    
    $scope.submit = function(){
        
        $.post(SRV+"/signin", {
            email: $scope.email,
            password: $scope.password
        }, function(resp){
            resp = JSON.parse(resp);
            console.log(resp);
            if(!resp.error){
                location.hash = "";
                $.cookie("session", resp.session, { expires: 7, path: '/' });
                _auth = true;
                updateAuth();
            }else{
                console.error(resp.errorMsg);
            }
        });
    }
    
    
});
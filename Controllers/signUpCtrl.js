app.controller('signUpCtrl', function($scope, $element, $timeout){
    
    $scope.submit = function(){
        
        $.post(SRV+"/signup", {
            email: $scope.email,
            name: $scope.name,
            password: $scope.password
        }, function(resp){
            resp = JSON.parse(resp);
            console.log(resp);
            if(!resp.error){
                $.cookie('session', resp.session, { expires: 7, path: '/' });
                _auth = true;
                updateAuth();
            }else{
                console.error(resp.errorMsg);
            }
        });
    }
    
    
});
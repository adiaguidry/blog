app.controller('loginCtrl', function(loginData, $log){
    var login = this;


    login.signOut = function() {
        $('.left-div').removeClass('left');
        $('.right-div').removeClass('right');
        setTimeout(function(){
            $('.login-form, .sign-up').removeClass('hidden');
        },500);
    };
    login.userLogin = function(em, pass) {
        loginData.callData(em, pass).then(function(response) {
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.login-form, .sign-up').addClass('hidden');
                $log.info(response)
            }
            else{
                alert('Incorrect username or password');
            }
        }, function(response){
            alert('Incorrect username or password');
     })
    };
});

app.factory("loginData", function($http){
    var loginService = {};

    loginService.callData = function(em, pass){

        var userData = $.param({email: em, password: pass});
        return $http({
            url: "php/login_user.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: userData
        });
    };

    return loginService;
});

app.controller('loginCtrl', function(loginData, $log){
    var login = this;

    login.signOut = function() {
        $('.left-div').removeClass('left');
        $('.right-div').removeClass('right');
        setTimeout(function(){
            $('.login-form, .sign-up').removeClass('hidden');
        },500);
    };
    login.userLogin = function(userEmail, userPassword) {
        loginData.callData(userEmail, userPassword).then(function(response) {
            $('.left-div').addClass('left');
            $('.right-div').addClass('right');
            $('.login-form, .sign-up').addClass('hidden');
            $log.info(response)
        }, function(response){
            alert('Incorrect username or password');
     })
    };
});

app.factory("loginData", function($http, $log){
    var loginService = {};

    loginService.callData = function(userEmail, userPassword){

        var userData = $.param({email: userEmail, password: userPassword});
        $log.info(em,pass);
        return $http({
            url: "login_user.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: userData
        });
    };

    return loginService;
});

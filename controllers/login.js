app.controller('loginCtrl', function(loginData){
    var login = this;

    //login.loginTrue = function() {

    //};
    //
    login.signOut = function() {
        $('.left-div').removeClass('left');
        $('.right-div').removeClass('right');
        setTimeout(function(){
            $('.login-form, .sign-up').removeClass('hidden');
        },500);
    };
    loginData.callData().then(function(response) {
        $('.left-div').addClass('left');
        $('.right-div').addClass('right');
        $('.login-form, .sign-up').addClass('hidden');
    }, function(response){
        alert(response);
    })
});

app.factory("loginData", function($http){
    var loginService = {};

    loginService.callData = function(em, pass){
        var userData = $.param({email: em, password: pass});
        return $http({
            url: "",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: userData
        });
    };

    return loginService;
});

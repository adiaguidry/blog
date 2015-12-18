app.controller('loginCtrl', function(loginData){
    var login = this;

    login.test = function() {
        $('.left-div').addClass('left');
        $('.right-div').addClass('right');
        $('.move, .under-tree').addClass('right-transition');
        setTimeout(function(){
            $('.login-form, .sign-up').addClass('hidden');
        },650);
    };

    login.signOut = function() {
        $('.left-div').removeClass('left');
        $('.right-div').removeClass('right');
        $('.move, .under-tree').removeClass('right-transition');
        setTimeout(function(){
            $('.login-form, .sign-up').removeClass('hidden');
        },500);
    };
    login.userLogin = function(userEmail, userPassword) {
        loginData.callData(userEmail, userPassword).then(function(response) {
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.move, .under-tree').addClass('right-transition');
                setTimeout(function(){
                    $('.login-form, .sign-up').addClass('hidden');
                },650);
            }
            else{
                alert(response.data.errors);
            }
        //}, function(response){
        //    alert('Incorrect username or password');
     })
    };
});

app.factory("loginData", function($http){
    var loginService = {};

    loginService.callData = function(userEmail, userPassword){

        var userData = $.param({email: userEmail, password: userPassword});

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

app.controller("modalCtrl", function(registerData) {
    var modal = this;

    modal.userRegister = function(regName, regEmail,regPass, regPic, $log){
        registerData.regData(regName, regEmail,regPass, regPic).then(function(response){
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.move, .under-tree').addClass('right-transition');
                setTimeout(function(){
                    $('.login-form, .sign-up').addClass('hidden');
                 },650);
                $log.info(response);
            }
            else{
                alert('Error: ' + response.data.errors);
                $log.info(response.data.errors);
            }
        })
    };
});

app.service("registerData", function($http,$log){
    var reg = {};

    reg.regData = function(regName, regEmail, regPass, regPic){
        var userRegData = $.param({display_name: regName, email: regEmail, password: regPass, profilePicture: regPic});
        $log.info(regName, regEmail, regPass, regPic);

        return $http({
            url: "php/register_user.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: userRegData
        });
    };
    return reg;
});

app.controller("logoutCtrl", function($http, $log){
    var logout = this;

    logout.signOut = function() {

        return $http({
            url: "php/logout_user.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
            if(response.data.success) {
                $('.left-div').removeClass('left');
                $('.right-div').removeClass('right');
                $('.move, .under-tree').removeClass('right-transition');
                setTimeout(function(){
                    $('.login-form, .sign-up').removeClass('hidden');
                },500);
                $log.info('hello' + response);
            }
            else{
                alert('Error: ' + response.data.errors);
                $log.info('bad' + response);
            }
        })
    };
});

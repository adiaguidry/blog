app.controller('loginCtrl', function(loginData, $log){
    var login = this;

    login.test = function() {
        $('.left-div').addClass('left');
        $('.right-div').addClass('right');
        $('.move, .under-tree ').addClass('right-transition');
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
    login.userLogin = function(em, pass) {
        loginData.callData(em, pass).then(function(response) {
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.move, .under-tree').addClass('right-transition');
                setTimeout(function(){
                    $('.login-form, .sign-up').addClass('hidden');
                },650);
                $log.info(response)
            }
            else{
                alert('Incorrect username or password');
            }
        //}, function(response){
        //    alert('Incorrect username or password');
     })
    };
});

app.factory("loginData", function($http,$log){
    var loginService = {};

    loginService.callData = function(userEmail, userPassword){

        var userData = $.param({email: userEmail, password: userPassword});
        $log.info(userEmail,userPassword);

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

app.controller("modalCtrl", function(registerData, $log){
    var modal = this;

    modal.userRegister = function(rEm,rPa, rPi){
        registerData.regData(rEm,rPa, rPi).then(function(response){
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.move, .under-tree').addClass('right-transition');
                setTimeout(function(){
                    $('.login-form, .sign-up').addClass('hidden');
                 },650);
                $log.info(response)
            }
            else{
                alert('Error: ' + response);
                $log.info(response)
            }
        })
    };
});

app.service("registerData", function($http,$log){
    var reg = {};

    reg.regData = function(regEmail, regPass, regPic){
        var userRegData = $.param({email: regEmail, password: regPass, profilePicture: regPic});
        $log.info(regEmail, regPass, regPic);

        $http({
            url: "",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: userRegData
        });
    };
    return reg;
});

app.controller('loginCtrl', function($scope, loginData){
    var login = this;
    $scope.credentials = {
        username: '',
        password: ''
    };
    login.signOut = function() {
        $('.left-div').removeClass('left');
        $('.right-div').removeClass('right');
        $('.move, .under-tree').removeClass('right-transition');
        loginData.clearInput();
        setTimeout(function(){
            $('.login-form, .sign-up').removeClass('hidden');
        },500);
    };
    login.userLogin = function(credentials) {
        loginData.callData(credentials).then(function(response) {
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.move, .under-tree').addClass('right-transition');
                loginData.clearInput();
                setTimeout(function(){
                    $('.login-form, .sign-up').addClass('hidden');
                },650);
            }
            else{
                alert(response.data.errors);
            }
     })
    };

});

app.factory("loginData", function($http){
    var loginService = {};

    loginService.clearInput = function() {
        $('.login-form, .modal-form')[0].reset();
    };

    loginService.callData = function(credentials){

        //var userData = $.param({credentials});

        return $http({
            url: "php/login_user.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: credentials
        });
    };

    return loginService;
});

app.controller("modalCtrl", function($scope, registerData, loginData) {
    var modal = this;
    $scope.reg = {
        display_name: '',
        email: '',
        password: '',
        fileToUpload: ''
    };

    modal.userRegister = function(reg){
        registerData.regData(reg).then(function(response){
            if(response.data.success) {
                $('.left-div').addClass('left');
                $('.right-div').addClass('right');
                $('.move, .under-tree').addClass('right-transition');
                loginData.clearInput();
                setTimeout(function(){
                    $('.login-form, .sign-up').addClass('hidden');
                 },650);
            }
            else{
                alert('Error: ' + response.data.errors);
            }
        })
    };
});

app.service("registerData", function($http,$log){
    var reg = {};

    reg.regData = function(reg){
        //var userRegData = $.param({display_name: regName, email: regEmail, password: regPass, profilePicture: regPic});
        //$log.info(regName, regEmail, regPass, regPic);

        return $http({
            url: "php/register_user.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: reg
        });
    };
    return reg;
});

app.controller("logoutCtrl", function($http, loginData){
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
                loginData.clearInput();
                setTimeout(function(){
                    $('.login-form, .sign-up').removeClass('hidden');
                },500);
            }
            else{
                alert('Error: ' + response.data.errors);
            }
        })
    };
});

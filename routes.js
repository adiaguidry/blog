var app = angular.module('blogApp', []);

app.controller('loginCtrl', function(){
    var login = this;

    login.loginTrue = function() {
        $('.left-div').addClass('left');
        $('.right-div').addClass('right');


        $('.login-form, .sign-up').addClass('hidden');

    };

    login.signOut = function() {
        $('.left-div').removeClass('left');
        $('.right-div').removeClass('right');
        setTimeout(function(){
            $('.login-form, .sign-up').removeClass('hidden');
        },500);


    };
});
app.controller('loginCtrl', function($scope, $rootScope, AUTH_EVENTS, AuthService, loginServ) {
    $scope.credentials = {
        username: '',
        password: ''
    };
    $scope.login = function (credentials) {
        AuthService.login(credentials).then(function (user_id) {
            $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
            $scope.setCurrentUser(user_id);
            loginServ.exit();
        }, function () {
            $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
        });
    }
})
.factory('AuthService', function ($http, Session) {
    var authService = {};

    authService.login = function (credentials) {
        return $http
            .post('php/login_user.php', credentials)
            .then(function (res) {
                return res.data.user_id;
            });
    };

    authService.isAuthenticated = function () {
        return !!Session.user_id;
    };

    return authService;
})
.constant('AUTH_EVENTS', {
    loginSuccess: 'auth-login-success',
    loginFailed: 'auth-login-failed',
    logoutSuccess: 'auth-logout-success',
    sessionTimeout: 'auth-session-timeout',
    notAuthenticated: 'auth-not-authenticated',
    notAuthorized: 'auth-not-authorized'
})
.service('loginServ', function(){
        var animate = this;
        animate.exit = function() {
            $('.left-div').addClass('left');
            $('.right-div').addClass('right');
            $('.move, .under-tree').addClass('right-transition');
            setTimeout(function(){
                $('.login-form, .sign-up').addClass('hidden');
            },650);
        };

        animate.enter = function (){
            $('.left-div').removeClass('left');
            $('.right-div').removeClass('right');
            $('.move, .under-tree').removeClass('right-transition');
            setTimeout(function(){
                $('.login-form, .sign-up').removeClass('hidden');
            },500);
        };
});
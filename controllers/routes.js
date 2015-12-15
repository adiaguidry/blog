app.controller('routeCtrl', function($routeProvider){

})
.config(function($routeProvider){
    $routeProvider
        .when('/',{
            templateUrl: 'pages/blog.html',
            controller: 'blogCtrl'
        });
})

app.controller('blogCtrl', function(){

})

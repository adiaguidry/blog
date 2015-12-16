app.controller('routeCtrl', function($routeProvider){

})
.config(function($routeProvider){
    $routeProvider
        .when('/',{
            templateUrl: 'pages/blog.html',
            controller: 'blogCtrl'
        });
});

app.controller('blogCtrl', function(getData, $log){
    var blog = this;
    blog.info ={};
    getData.callData()
        .then(function(response){
            blog.info = response.data.data;
            $log.info(blog.info);
        }, function(response){
            $log.info(response);
        });


});

app.factory("getData", function($http){
    var service = {};
    var url = "http://s-apis.learningfuze.com/blog/list.json";
    service.callData = function(){
        return $http({
            url: url,
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
    };

    return service;
});



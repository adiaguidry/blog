app.controller('routeCtrl', function($routeProvider){

})
.config(function($routeProvider){
    $routeProvider
        .when('/blog',{
            templateUrl: 'pages/blog.html',
            controller: 'blogCtrl'
        })
        .when('/profile',{
            templateUrl: 'pages/profile.html',
            controller: 'profileCtrl'
        })
        .when('/create',{
            templateUrl: 'pages/create.html',
            controller: 'createCtrl'
        });
    //    .when('/',{
    //        templateUrl: 'pages/lander.html'
    //    }
    //);
});

app.controller('blogCtrl', function(getData, $log){
    var blog = this;
    blog.array =[{title: 'Apples', summary: "Lorem Ipsum is simply dummy of the printing and typesetting text of is simply dummy text of the printing and typesetting industry."},
        {title: 'Oranges', summary: "Lorem Ipsum is simply dummy of the printing and typesetting text of is simply dummy text of the printing and typesetting industry."},
        {title: 'Bananas', summary: "Lorem Ipsum is simply dummy of the printing and typesetting text of is simply dummy text of the printing and typesetting industry."},];
    blog.info ={};
    getData.callData()
        .then(function(response){
            blog.info = response.data.data;
            blog.array.push(blog.info);
        }, function(response){
            $log.info(response);
        });
});
app.controller('createCtrl', function(){

});
app.controller('profileCtrl', function(){
   var pro = this;
    pro.edit = true;

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

app.controller("logoutCtrl", function(){});



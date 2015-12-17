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
app.controller('createCtrl', function($http, $log){
    var blog = this;
    blog.creatBlog = function(){
        var enrty = $.param({
            title: 'title',
            summary: 'summary'
        });
    };
    $http({
        url: 'http://s-apis.learningfuze.com/blog/create.json',
        header: {'Content-Type': 'application/x-www-form-urlencoded'},
        method: 'POST'
    }).success(function(response){
        $log.info('success in create: ', response);
    }).error(function(){
        $log.error('error');
    })
});
app.controller('profileCtrl', function($http, $log){
   var pro = this;
    pro.edit = true;
    $http({
        url: 'php/get_profile.php',
        header: {'Content-Type': 'application/x-www-form-urlencoded'},
        method: 'POST',
        data:{uid:5}
    }).success(function(response){
        $log.info('success for profile; ', response);
        pro.info = response.data;
    }).error(function(){
        $log.error('error' + response);
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

app.controller("logoutCtrl", function(){});



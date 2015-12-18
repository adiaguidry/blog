app.controller('routeCtrl', function ($routeProvider) {

})

    .config(function ($routeProvider) {
        $routeProvider
            .when('/blog', {
                templateUrl: 'pages/blog.html',
                controller: 'blogCtrl'
            })
            .when('/profile', {
                templateUrl: 'pages/profile.html',
                controller: 'profileCtrl'
            })
            .when('/create', {
                templateUrl: 'pages/create.html',
                controller: 'createCtrl'
            });

    });


app.controller('blogCtrl', function (getData, $log) {
    var blog = this;

    blog.array = [{
        title: 'Apples',
        summary: "Lorem Ipsum is simply dummy of the printing and typesetting text of is simply dummy text of the printing and typesetting industry."
    },
        {
            title: 'Oranges',
            summary: "Lorem Ipsum is simply dummy of the printing and typesetting text of is simply dummy text of the printing and typesetting industry."
        },
        {
            title: 'Bananas',
            summary: "Lorem Ipsum is simply dummy of the printing and typesetting text of is simply dummy text of the printing and typesetting industry."
        },];
    blog.info = {};
    getData.callData()
        .then(function (response) {
            blog.info = response.data.data;
            blog.array.push(blog.info);
        }, function (response) {
            $log.info(response);
        });
});
app.controller('createCtrl', function($http, $log){
    var create = this;

    create.createBlog = function(blogTitle, blogArea, blogTags){
        $log.info(blogTitle);
        var blogData = $.param({title: blogTitle, text: blogArea, tags: blogTags, public: true});
        $http({

            url: 'php/create_blog.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            method: 'POST',
            data: blogData
        }).then(function(response){
            $log.info('success in create: ', response);

        }, function(response){
            $log.error(response);
        })

    };
});

app.controller('profileCtrl', function ($http, $log, getData) {
    var pro = this;
    pro.edit = true;

    //$http({
    //    url: 'http://s-apis.learningfuze.com/blog/profile.json',
    //    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    //    method: 'POST'
    //}).success(function(response){
    //    $log.info('success for profile; ', response);
    //    pro.info = response.data;
    //}).error(function(){
    //    $log.error('error');
    //});



        getData.callData()
            .then(function (response) {
               pro.data = response.data.data;
                $log.info("the profile: this one", pro.data);
            }, function (response) {
                $log.info(response);
            });


});

app.factory("getData", function ($http) {
    var service = {};

    service.callData = function(keywords){
        var searchData = $.param({ search: keywords});

        return $http({
            url: "php/get_blog.php",
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: searchData
        });
    };
    return service;
});




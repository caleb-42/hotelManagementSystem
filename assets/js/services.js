app.factory('List', function(){
    return {
        createNew: function(a,b,c){
            return new List(a,b,c);
        }
    }
});

app.factory('jsonGet', ['$http', function($http){
    return {
        data: function(rest,args){
            return $http.get(rest,
            {
                params:args
            }).then(function(result){
                return result.data;
            });
        }
    }
}]);
app.factory('jsonPost', ['$http', function($http){
    return {
        data: function(rest, json){
            var req = $http(
                {
                    method: "post",
                    url: rest,
                    data: $.param(json),
                    headers : {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function(result){
                return result.data;
            });
            return req;
        }
    }
}]);
/*Uncaught Error: [$rootScope:infdig] http://errors.angularjs.org/1.2.32/$rootScope/infdig?p0=10&p1=%5B%5D
at angular.js:36
at h.$digest (angular.js:12742)
at h.$apply (angular.js:12968)
at l (angular.js:8479)
at w (angular.js:8693)
at XMLHttpRequest.y.onreadystatechange (angular.js:8632)*/
app.directive('userlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/users/listTemplates.php?list=users',

        scope: false,

        link: function (scope, element, attrs) {
            scope.users.jslist = {
                createList: function () {
                    listdetails = scope.users.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.users.jslist.values = result;
                        scope.users.jslist.selected = null;
                    });
                    scope.users.listhddata = [
                        {
                            name: "Name",
                            width: "col-6",
                        },
                        {
                            name: "Role",
                            width: "col-6",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.users.jslist.selected = id;
                    scope.users.jslist.selectedObj = scope.users.jslist.newItemArray[index];
                    console.log(scope.users.jslist.newItemArray[index]);
                    scope.sessions.jslist.createList();
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.users.jslist.createList();
        }
    };
}]);

app.directive('sessionlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/users/listTemplates.php?list=sessions',

        scope: false,

        link: function (scope, element, attrs) {
            scope.sessions.jslist = {
                createList: function () {
                    if(!scope.users.jslist.selected){
                        return;
                    }
                    listdetails = scope.sessions.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    resultfiltered = [];

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        result.forEach(function (element) {
                            if (element.user_name == scope.users.jslist.selectedObj.user_name && element.role == scope.users.jslist.selectedObj.role) {
                                resultfiltered.push(element);
                                console.log(element);
                            }else{
                                return;
                            }
                        });
                        scope.sessions.jslist.values = resultfiltered;
                        //scope.users.jslist.selected = null;
                    });
                    scope.sessions.listhddata = [
                        {
                            name: "Username",
                            width: "col-4",
                        },
                        {
                            name: "Logged On Time",
                            width: "col-4",
                        },
                        {
                            name: "Logged Off Time",
                            width: "col-4",
                        }
                    ];
                }
            }
            scope.sessions.jslist.createList();
        }
    };
}]);


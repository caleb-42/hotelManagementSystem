app.directive('userlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div class = "listcont"><div class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in users.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (users.jslist.newItemArray = (users.jslist.values | filter:searchbox.imp))" ng-click = "users.jslist.select($index, items.id)" ng-class = "{\'actparent\' :users.jslist.selected == items.id}"><span class = "username col-6">{{items.user_name}}</span><span class = "text-center role col-6">{{items.role}}</span></li></ul></div></div>',

        scope: false,

        link: function (scope, element, attrs) {
            scope.users.jslist = {
                createList: function () {
                    listdetails = scope.users.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.users.jslist.values = result;
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
        template: '<div class = "row h-100 {{users.jslist.selected ? \'gone\' : \'align-items-center\'}} relatv "><h4 class=" text-center w-100 "> Select A User</h4></div><div class = "listcont {{!users.jslist.selected ? \'gone\' : \'notgone\'}}"><div class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in sessions.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "itemlistrow row align-items-center f-12" ng-repeat = "session in sessions.jslist.values"><span class = "username col-4">{{session.user_name}}</span><span class = "text-center login col-4">{{session.logged_on_time}}</span><span class = "text-center logoff col-4">{{session.logged_off_time}}</span></li></ul></div></div>',

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
                        scope.user.jslist.selected = null;
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


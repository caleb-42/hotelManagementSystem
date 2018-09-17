app.directive('userlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div  class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in users.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (users.jslist.newItemArray = (users.jslist.values | filter:searchbox.imp))" ng-click = "users.jslist.select($index, items.id)" ng-class = "{\'actparent\' :users.jslist.selected == items.id}"><span class = "username col-6">{{items.item}}</span><span class = "text-center role col-6">{{items.current_stock}}</span></li></ul></div>',

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
                }
            }
            scope.users.jslist.createList();
        }
    };
}]);


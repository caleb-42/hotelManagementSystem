app.directive('jslist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=guest',

        scope: false,

        link: function (scope, element, attrs) {
            scope.guest.jslist = {
                createList: function () {
                    listdetails = scope.guest.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.guest.jslist.values = result;
                        scope.guest.jslist.selected = null;
                    });
                    scope.guest.listhddata = [
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
                    scope.guest.jslist.selected = id;
                    scope.guest.jslist.selectedObj = scope.guest.jslist.newItemArray[index];
                    console.log(scope.guest.jslist.newItemArray[index]);
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.guest.jslist.createList();
        }
    };
}]);

salesApp.directive('ordersgrid', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?type=ordersgrid',
        scope: {
            ordercheck: "&"
        },
        link: function (scope, element, attrs) {
            $rootScope.$on("neworder", function (evt, params) {
                scope.order.listarray = $.extend(true, {}, params);
                arr = $.map(scope.order.listarray, function (el) {
                    return el
                });
                scope.order.list = arr;
                scope.order.list.length == 1 ? scope.ordercheck() : null;
                $(".orderRow").fadeOut(10, function () {
                    $(".orderRow").delay(700).fadeIn(100);
                }).delay(50);

            });
            $rootScope.$on("deleteorder", function (evt, params) {
                scope.order.focused = null;
                scope.order.list.length == 1 ? scope.ordercheck() : null;
                //console.log(scope.order.list[scope.order.focusedIndex]);
                scope.order.list.splice(scope.order.focusedIndex, 1);
            });
            $rootScope.$on("DeselectOrder", function (evt, params) {
                if (scope.order.focused) {
                    scope.order.focused = null;
                    $rootScope.$emit("orderDeselected", {});
                }
            });
            scope.order = {
                focus: function (ordername, index) {
                    //console.log(index);
                    if (ordername == scope.order.focused) {
                        scope.order.focused = null;
                        $rootScope.$emit("orderDeselected", {});
                    } else {
                        scope.order.focused = ordername;
                        scope.order.focusedIndex = index;
                        $rootScope.$emit("orderSelected", {
                            list: scope.order.list[index],
                            indx: index
                        });
                    }

                },
                list: []
            }
        }
    };
}]);

salesApp.directive('accordion', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?type=accordion',
        scope: {
            
        },
        link: function (scope, element, attrs) {
            
        }
    };
}]);



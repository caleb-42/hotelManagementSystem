app.directive('saleshistorylist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/records/listTemplates.php?list=sales',

        scope: false,

        link: function (scope, element, attrs) {
            scope.salesHistory.jslist = {
                createList: function () {
                    listdetails = scope.salesHistory.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.salesHistory.jslist.values = result;
                    });
                    scope.salesHistory.listhddata = [
                        {
                            name: "Tranx Ref",
                            width: "col-1",
                        },
                        {
                            name: "Method",
                            width: "col-2",
                        },
                        {
                            name: "Items",
                            width: "col-1",
                        },
                        {
                            name: "Cost",
                            width: "col-1",
                        },
                        {
                            name: "Discnt Cost",
                            width: "col-1",
                        },
                        {
                            name: "Tranx Discnt",
                            width: "col-1",
                        },
                        {
                            name: "Deposited",
                            width: "col-2",
                        },
                        {
                            name: "Balance",
                            width: "col-1",
                        },
                        {
                            name: "Status",
                            width: "col-2",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.salesHistory.jslist.selected = id;
                    scope.salesHistory.jslist.selectedObj = scope.salesHistory.jslist.newItemArray[index];
                    console.log(scope.salesHistory.jslist.selectedObj);
                    $rootScope.$emit('tranxselect', {sales_ref : id, obj: scope.salesHistory.jslist.selectedObj});
                }
            }
            scope.salesHistory.jslist.createList();
        }
    };
}]);

app.directive('stockhistorylist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/records/listTemplates.php?list=stocks',

        scope: false,

        link: function (scope, element, attrs) {
            scope.stockHistory.jslist = {
                createList: function () {
                    listdetails = scope.stockHistory.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.stockHistory.jslist.values = result;
                    });
                    scope.stockHistory.listhddata = [
                        {
                            name: "Tranx Ref",
                            width: "col-2",
                        },
                        {
                            name: "Item",
                            width: "col-1",
                        },
                        {
                            name: "Previous Stock",
                            width: "col-2",
                        },
                        {
                            name: "Quantity",
                            width: "col-1",
                        },
                        {
                            name: "New Stock",
                            width: "col-2",
                        },
                        {
                            name: "Category",
                            width: "col-2",
                        },
                        {
                            name: "Tranx Date",
                            width: "col-2",
                        }
                    ];
                }
            }
            scope.stockHistory.jslist.createList();
        }
    };
}]);

app.directive('customerslist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/records/listTemplates.php?list=customers',

        scope: false,

        link: function (scope, element, attrs) {
            scope.customers.jslist = {
                createList: function () {
                    listdetails = scope.customers.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.customers.jslist.values = result;
                        scope.customers.jslist.selected = null;
                    });
                    scope.customers.listhddata = [
                        {
                            name: "Cust ID",
                            width: "col-2",
                        },
                        {
                            name: "Name",
                            width: "col-2",
                        },
                        {
                            name: "Phone",
                            width: "col-2",
                        },
                        {
                            name: "Address",
                            width: "col-2",
                        },
                        {
                            name: "Gender",
                            width: "col-1",
                        },
                        {
                            name: "Oustanding Bal",
                            width: "col-3",
                        }
                    ];
                },
                select: function (index, id) {
                    if($filter('limitTo')(id, 3) == 'LOD'){
                        //return;
                    }
                    scope.customers.jslist.selected = id;
                    scope.customers.jslist.selectedObj = scope.customers.jslist.newItemArray[index];
                    console.log(scope.customers.jslist.selectedObj);
                    $rootScope.$emit('custselect', {customer_ref : id, obj: scope.customers.jslist.selectedObj});
                    //scope.palistsales.jslist.createList(params);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                },
            }
            scope.customers.jslist.createList();
            $rootScope.$on('createcustomerlist', function(evt, params){
                scope.customers.jslist.createList();
            });
        }
    };
}]);

app.directive('listsale', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/records/listTemplates.php?list=tranxsales',

        scope: false,

        link: function (scope, element, attrs) {
            scope.listsales.jslist = {
                createList: function (params) {
                    listdetails = scope.listsales.itemlist(params);
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        /* if (!result) {
                            return 0;
                        } */
                        console.log(result);
                        scope.listsales.jslist.values = result;
                    });
                    scope.listsales.listhddata = [
                        {
                            name: "Item",
                            width: "col-3 f-13",
                        },
                        {
                            name: "Qty",
                            width: "col-1 f-13",
                        },
                        {
                            name: "Unit Cost",
                            width: "col-2 f-13",
                        },
                        {
                            name: "Cost",
                            width: "col-2 f-13",
                        },
                        {
                            name: "Discnt Amt",
                            width: "col-2 f-13",
                        },
                        {
                            name: "Discnt %",
                            width: "col-1 f-13",
                        }
                    ];
                }
            };
            //scope.listsales.jslist.createList({sales_ref : 0});
            $rootScope.$on('tranxselect' , function(evt, params){
                //console.log('sssss');
                scope.listsales.jslist.createList(params);
                scope.listsales.jslist.tranx = params.obj;
                scope.listsales.jslist.active = true;
            });
        }
    };
}]);

app.directive('listtranx', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/records/listTemplates.php?list=tranxlist',

        scope: false,

        link: function (scope, element, attrs) {
            scope.listtranxs.jslist = {
                createList: function (params) {
                    listdetails = scope.listtranxs.itemlist(params);
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        /* if (!result) {
                            return 0;
                        } */
                        console.log(result);
                        scope.listtranxs.jslist.values = result;
                    });
                    scope.listtranxs.listhddata = [
                        {
                            name: "Tranx Ref",
                            width: "col-2",
                        },
                        {
                            name: "Cost",
                            width: "col-4",
                        },
                        {
                            name: "Deposited",
                            width: "col-4",
                        },
                        {
                            name: "Balance",
                            width: "col-2",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.listtranxs.jslist.selected = id;
                    scope.listtranxs.jslist.selectedObj = scope.listtranxs.jslist.values[index];
                    console.log(scope.listtranxs.jslist.selectedObj);
                    //scope.palistsales.jslist.createList(params);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                },
                createcustomerList : function()
                {
                    scope.listtranxs.jslist.active = false;
                    $rootScope.$emit('createcustomerlist', {})
                },
                pay_method : 'Cash'
            };
            //scope.listsales.jslist.createList({sales_ref : 0});
            $rootScope.$on('custselect' , function(evt, params){
                console.log('sssss');
                scope.listtranxs.jslist.data = params;
                scope.listtranxs.jslist.createList(scope.listtranxs.jslist.data);
                scope.listtranxs.jslist.tranx = params.obj;
                scope.listtranxs.jslist.active = true;
            });
        }
    };
}]);
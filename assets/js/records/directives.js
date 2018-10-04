app.directive('saleshistorylist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div class = "listcont h-100"><div class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in salesHistory.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (salesHistory.jslist.newItemArray = (salesHistory.jslist.values | filter:searchbox.imp))"><span class = "custref col-1">{{hist.customer_ref}}</span><span class = "text-center paymeth col-1">{{hist.pay_method}}</span><span class = "text-center items col-1">{{hist.total_items}}</span><span class = "text-center cost col-1">{{hist.total_cost}}</span><span class = "text-center discost col-1">{{hist.discounted_total_cost}}</span><span class = "text-center discnt col-1">{{hist.transaction_discount}}</span><span class = "text-center deposit col-1">{{hist.deposited}}</span><span class = "text-center bal col-1">{{hist.balance}}</span><span class = "text-center status col-1">{{hist.payment_status}}</span><span class = "text-center tranxref col-1">{{hist.txn_ref}}</span><span class = "text-center tranxtime col-1">{{hist.txn_time}}</span><span class = "text-center salesrep col-1">{{hist.sales_rep}}</span></li></ul></div></div>',

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
                            name: "Customer Ref",
                            width: "col-1",
                        },
                        {
                            name: "Method",
                            width: "col-1",
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
                            name: "Discounted Cost",
                            width: "col-1",
                        },
                        {
                            name: "Tranx Discount",
                            width: "col-1",
                        },
                        {
                            name: "Deposited",
                            width: "col-1",
                        },
                        {
                            name: "Balance",
                            width: "col-1",
                        },
                        {
                            name: "Payment Status",
                            width: "col-1",
                        },
                        {
                            name: "Tranx Ref",
                            width: "col-1",
                        },
                        {
                            name: "Tranx Time",
                            width: "col-1",
                        },
                        {
                            name: "Sales Rep",
                            width: "col-1",
                        }
                    ];
                }
            }
            scope.salesHistory.jslist.createList();
        }
    };
}]);

app.directive('stockhistorylist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div class = "listcont h-100"><div class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in stockHistory.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (stockHistory.jslist.newItemArray = (stockHistory.jslist.values | filter:searchbox.imp))"><span class = "text-left tranxref col-2">{{hist.txn_ref}}</span><span class = "text-center item col-1">{{hist.item}}</span><span class = "text-center prevstk col-2">{{hist.prev_stock}}</span><span class = "text-center qty col-1">{{hist.quantity}}</span><span class = "text-center newstk col-2">{{hist.new_stock}}</span><span class = "text-center cat col-2">{{hist.category}}</span><span class = "text-center tranxdate col-2">{{hist.txn_date}}</span></li></ul></div></div>',

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

app.directive('customerslist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div class = "listcont h-100"><div class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in customers.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (customers.jslist.newItemArray = (customers.jslist.values | filter:searchbox.imp))" ng-click = "customers.jslist.select($index, hist.id);" ng-class = "{\'actparent\' : customers.jslist.selected == hist.id}"><span class = "text-left custref col-2">{{hist.customer_ref}}</span><span class = "text-center fname col-3">{{hist.first_name}}</span><span class = "text-center lname col-3">{{hist.last_name}}</span><span class = "text-center outbal col-4">{{hist.outstanding_balance}}</span></li></ul></div></div>',

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
                    });
                    scope.customers.listhddata = [
                        {
                            name: "Cust Ref",
                            width: "col-2",
                        },
                        {
                            name: "Firstname",
                            width: "col-3",
                        },
                        {
                            name: "Lastname",
                            width: "col-3",
                        },
                        {
                            name: "Oustanding Bal",
                            width: "col-4",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.customers.jslist.selected = id;
                    scope.customers.jslist.selectedObj = scope.customers.jslist.newItemArray[index];
                    console.log(scope.customers.jslist.selectedObj);
                },
            }
            scope.customers.jslist.createList();
        }
    };
}]);
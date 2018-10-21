recordsApp.controller("records", ["$rootScope", "$scope", 'jsonPost', '$filter',  function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Sales: {
                name: 'Sales',
                options: {
                    rightbar : {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            },
            Stocks: {
                name: 'Stocks',
                options: {
                    rightbar : false
                }
            },
            Customers: {
                name: 'Customers',
                options: {
                    rightbar : {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            }
        },
        selected: {
            name: 'Sales',
            options: {
                rightbar : {
                    present: true,
                    rightbarclass: 'w-35',
                    primeclass: 'w-65'
                }
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
};
$scope.rightSidebar = {
    itemlist: function () {
        return {
            jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_sessions.php", {})
        }
    },
    subclass: {

    }
};

$scope.listsales = {
    itemlist: function (ref) {
        //console.log('ewere');
        return {
            jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_sales.php", ref)
        }
    }
};
$scope.listtranxs = {
    itemlist: function (ref) {
        //console.log('ewere');
        return {
            jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_transactions.php", ref)
        }
    },
    debtpay : function (ref) {
        //console.log('ewere');
        ref.trasaction_ref = $scope.listtranxs.jslist.selected;
        //console.log(ref);
        return {
            jsonfunc: jsonPost.data("../php1/restaurant_bar/restaurant_balance_pay.php", {
                payment_details: $filter('json')(ref)
            }).then(function (response) {
                $scope.listtranxs.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.listtranxs.jslist.createList($scope.listtranxs.jslist.data);
                $scope.listtranxs.jslist.createcustomerList();
                $scope.listtranxs.jslist.selected = null;
                $scope.listtranxs.jslist.toggleIn();
            })
        }
    }
}

}]);

recordsApp.controller("saleshistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.salesHistory = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_transactions.php", {})
            }
        }
    }

}]);

recordsApp.controller("stockhistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.stockHistory = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_stock_transaction.php", {})
            }
        }
    }

}]);

recordsApp.controller("customers", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.customers = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_customers.php", {}),
                /* jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_customers.php", {}) */
            }
        },
        addCustomer: function (jsoncust) {
            console.log("new cust", jsoncust);

            jsonPost.data("../php1/restaurant_bar/add_customer.php", {
                new_customer: $filter('json')(jsoncust)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.customers.jslist.createList();
            });
        },
        updateCustomer: function (jsoncust) {
            console.log("new cust", jsoncust);
            jsoncust.customer_id = $scope.customers.jslist.selected;
            jsonPost.data("../php1/restaurant_bar/update_customer.php", {
                update_customer: $filter('json')(jsoncust)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.customers.jslist.createList();
            });
        },
        deleteCustomer: function () {
            jsoncust = {};
            jsoncust.customers = [$scope.customers.jslist.selectedObj];
            console.log("new users", jsoncust);
            jsonPost.data("../php1/restaurant_bar/admin/del_customers.php", {
                del_customers: $filter('json')(jsoncust)
            }).then(function (response) {
                //$scope.customers.jslist.toggleOut();
                console.log(response);
                $scope.customers.jslist.createList();
                //$scope.customers.jslist.toggleIn();
            });
        }
    }

}]);



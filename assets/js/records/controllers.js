recordsApp.controller("records", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        selected: 'Sales',
        navs: [
            {
                name: 'Sales'
            },
            {
                name: 'Stocks'
            },
            {
                name: 'Customers'
            }
        ],
        selectNav: function (navname) {
            $scope.tabnav.selected = navname;
        }
    };
    $scope.rightSidebar = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/admin/list_sessions.php", {})
            }
        },
        subclass : {

        }
    }

}]);

recordsApp.controller("saleshistory", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.salesHistory = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/admin/list_transactions.php", {})
            }
        }
    }

}]);

recordsApp.controller("stockhistory", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.stockHistory = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/admin/list_stock_transaction.php", {})
            }
        }
    }

}]);

recordsApp.controller("customers", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.customers = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/admin/list_customers.php", {})
            }
        },
        addCustomer: function (jsoncust) {
            console.log("new cust", jsoncust);

            jsonPost.data("assets/php1/restaurant_bar/add_customer.php", {
                new_customer: $filter('json')(jsoncust)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.customers.adding = false;
                $scope.customers.jslist.createList();
            });
        }
    }

}]);

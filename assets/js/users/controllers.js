usersApp.controller("users", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        selected: 'Users',
        navs: {
            nav1: {
                name: 'Users'
            },
            /*nav2: {
                name: 'History'
            }*/
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = navname;
        }
    };
    $scope.users = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/list_users.php", {})
            }
        },
        addUser: function (jsonprod) {
            jsonprod.discount_rate = 0;
            jsonprod.discount_criteria = 0;
            jsonprod.discount_available = "";
            console.log("new product", jsonprod);

            jsonPost.data("assets/php1/restaurant_bar/admin/add_item.php", {
                new_item: $filter('json')(jsonprod)
            }).then(function (response) {
                console.log(response);
                $scope.stocks.addingProduct = false;
                $scope.stocks.jslist.createList();
            });
        },
        updateUser: function (jsonprod) {
            console.log("new product", jsonprod);
        }
    };


}]);

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
        name: "ejjsdv",
        addUser: function (jsonprod) {
            console.log("new user", jsonprod);

            jsonPost.data("assets/php1/restaurant_bar/admin/add_user.php", {
                new_user: $filter('json')(jsonprod)
            }).then(function (response) {
                console.log(response);
                $scope.stocks.adding = false;
                $scope.stocks.jslist.createList();
            });
        },
        updateUser: function (jsonprod) {
            console.log("new product", jsonprod);
        }
    };


}]);

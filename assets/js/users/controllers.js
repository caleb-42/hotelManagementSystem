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
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/admin/list_users.php", {})
            }
        },
        addUser: function (jsonprod) {
            console.log("new user", jsonprod);

            jsonPost.data("assets/php1/restaurant_bar/admin/add_user.php", {
                new_user: $filter('json')(jsonprod)
            }).then(function (response) {
                console.log(response);
                $scope.users.adding = false;
                $scope.users.jslist.createList();
            });
        },
        updateUser: function (jsonuser) {
            jsonuser.id = $scope.users.jslist.selected;
            console.log("new product", jsonuser);
            jsonPost.data("assets/php1/restaurant_bar/admin/edit_user.php", {
                update_user: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $scope.users.updatingProduct = false;
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        },
        deleteUser: function () {
            jsonuser = {};
            jsonuser.users = [$scope.users.jslist.selectedObj];
            console.log("new users", jsonuser);
            jsonPost.data("assets/php1/restaurant_bar/admin/del_user.php", {
                del_users: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        }
    };

}]);

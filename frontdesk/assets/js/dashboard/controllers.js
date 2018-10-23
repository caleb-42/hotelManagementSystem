salesApp.controller("sales", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Dashboard: {
                name: 'Dashboard',
                options: {
                    rightbar: false
                }
            },
            Guests: {
                name: 'Guests',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            },
            Room: {
                name: 'Room',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            },
            /* History: {
                name: 'History',
                options: {
                    rightbar: false
                }
            } */
        },
        selected: {
            name: 'Dashboard',
            options: {
                rightbar: false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.guest = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_guests.php", {})
            }
        },
        addGuest: function (jsonguest) {
            jsonguest.room_outstanding = 0;
            console.log("new Guest", jsonguest);

            jsonPost.data("../php1/front_desk/add_guest.php", {
                new_user: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
            });
        },
        updateGuest: function (jsonguest) {
            jsonguest.id = $scope.guest.jslist.selected;
            console.log("new product", jsonguest);
            jsonPost.data("../php1/restaurant_bar/admin/edit_user.php", {
                update_user: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
                $scope.guest.jslist.toggleIn();
            });
        },
        deleteGuest: function () {
            jsonguest = {};
            jsonguest.guest = [$scope.guest.jslist.selectedObj];
            console.log("new users", jsonguest);
            jsonPost.data("../php1/restaurant_bar/admin/del_user.php", {
                del_users: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $scope.guest.jslist.createList();
                $scope.guest.jslist.toggleIn();
            });
        }
    };

}]);

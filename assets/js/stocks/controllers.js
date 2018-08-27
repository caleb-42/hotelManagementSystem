stocksApp.controller("stocks", ["$rootScope", "$scope", "$route", 'jsonPost', function ($rootScope, $scope, $route, jsonPost) {
    $scope.tabnav = {
        selected: 'Products',
        navs: {
            nav1: {
                name: 'Products'
            },
            /*nav2: {
                name: 'History'
            }*/
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = navname;
        }
    };
    $scope.products = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/restaurant_items.php", {}) 
            }
        },
        crud : ""
    };
}]);

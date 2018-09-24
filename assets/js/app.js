var app = angular.module('app', ['ngAnimate', 'ngRoute', 'ngSanitize', 'salesApp', 'stocksApp', 'usersApp','ngCroppie']);

app.controller("appctrl", ["$rootScope", "$scope", function ($rootScope, $scope) {
    $rootScope.settings = {
        modal: {
            active: "",
            name: "",
            size: "",
            msg: ""
        },
        userDefinition : function(user, role){
            $rootScope.settings.user = user;
            $rootScope.settings.role = role;
        },
        user: "",
        role : "",
        log : true
    }
    $scope.sidebarnav = {
        navig: {
            activeNav: "Sales",
            mkactiveNav: function (nav) {
                $scope.sidebarnav.navig.activeNav = nav;
            },
            navs: [
                {
                    name: "Sales",
                    listClass: "anim",
                    iconClass: "mr-3",
                    innerHtml: '<img width = 25px height = 30px style="margin-top:-20px;" src = "assets/img/moneybag-08.png"/>',
                },
                {
                    name: "Stocks",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-foursquare",
                    innerHtml: '',
                },
                {
                    name: "Users",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-user",
                    innerHtml: '',
                },
                {
                    name: "History",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-history",
                    innerHtml: '',
                }
            ]
        },
        menuicon: {
            toggleactive: function () {
                console.log("rertr");
                $scope.sidebarnav.menuicon.active = $scope.sidebarnav.menuicon.active ? false : true;
            }
        }
    }
}]);

var salesApp = angular.module('salesApp', []);
var stocksApp = angular.module('stocksApp', []);
var usersApp = angular.module('usersApp', []);

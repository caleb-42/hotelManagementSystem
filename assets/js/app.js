var app = angular.module('app', ['ngAnimate', 'ngRoute', 'ngSanitize', 'salesApp', 'stocksApp', 'usersApp', 'recordsApp', 'ngCroppie']);

app.controller("appctrl", ["$rootScope", "$scope", function ($rootScope, $scope) {
    $rootScope.settings = {
        modal: {
            active: "",
            name: "",
            size: "",
            msg: "",
            adding : false,
            msgprompt: function (arr) {
                if (typeof (arr) == "string") {
                    $rootScope.settings.modal.msg = "BACKEND CODE ERROR";
                    $rootScope.settings.modal.msgcolor = "choral";
                    $rootScope.settings.modal.adding = false;
                    $rootScope.settings.modal.fademsg();
                } else {
                    $rootScope.settings.modal.msg = arr[1];
                    if(arr[0] == "OUTPUT"){
                        $rootScope.settings.modal.msgcolor = "green";
                        $rootScope.settings.modal.close();
                    }else{
                        $rootScope.settings.modal.msgcolor = "choral";
                        $rootScope.settings.modal.fademsg();
                    }
                    $rootScope.settings.modal.adding = false;
                }
            }
        },
        userDefinition : function (user, role) {
            $rootScope.settings.user = user;
            $rootScope.settings.role = role;
        },        
        user: "",
        role: "",
        log: true
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
                    name: "Records",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-history",
                    innerHtml: '',
                }
            ]
        },
        menuicon: {
            active : true,
            toggleactive: function () {
                console.log("rertr");
                $scope.sidebarnav.menuicon.active = $scope.sidebarnav.menuicon.active ? false : true;
            }
        }
    };
}]);

var salesApp = angular.module('salesApp', []);
var stocksApp = angular.module('stocksApp', []);
var usersApp = angular.module('usersApp', []);
var recordsApp = angular.module('recordsApp', []);

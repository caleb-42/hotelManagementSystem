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
    $scope.stocks = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("assets/php1/restaurant_bar/restaurant_items.php", {})
            }
        },
        addProduct : function(jsonprod){
            console.log("new product", jsonprod);
        },
        updateProduct : function(jsonprod){
            console.log("new product", jsonprod);
        }
        /* croppie : {
            inputImage: "/assets/img/4.png",
            outputImage: null,

            onUpdate: function (data) {
                //console.log(data);
            }
        } */
    };
    $scope.details = {
        discount:{
            selected_discount : "item"
        }
    }


}]);

/* function ExampleCtrl() {
    var vm = this;

    vm.inputImage = "./././assets/img/4.png";
    vm.outputImage = null;

    vm.onUpdate = function(data) {
        //console.log(data);
    };
}
stocksApp.controller('ExampleCtrl', [ExampleCtrl]); */

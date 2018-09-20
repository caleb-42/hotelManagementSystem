stocksApp.controller("stocks", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope,  jsonPost, $filter) {
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
        addProduct: function (jsonprod) {
            jsonprod.discount_rate = 0;
            jsonprod.discount_criteria = 0;
            jsonprod.discount_available = "";
            console.log("new product", jsonprod);

            jsonPost.data("assets/php1/restaurant_bar/admin/add_item.php", {
                new_item: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.stocks.jslist.toggleOut();
                console.log(response);
                $scope.stocks.addingProduct = false;
                $scope.stocks.jslist.createList();
                $scope.stocks.jslist.toggleIn();
            });
        },
        updateProduct: function (jsonprod) {
            jsonprod.id = $scope.stocks.jslist.selected;
            console.log("new product", jsonprod);
            jsonPost.data("assets/php1/restaurant_bar/admin/edit_item.php", {
                update_item: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.stocks.jslist.toggleOut();
                console.log(response);
                $scope.stocks.updatingProduct = false;
                $scope.stocks.jslist.createList();
                $scope.stocks.jslist.toggleIn();
            });
        },
        deleteProduct: function () {
            jsonprod = {};
            jsonprod.items = [$scope.stocks.jslist.selectedObj];
            console.log("new product", jsonprod);
            jsonPost.data("assets/php1/restaurant_bar/admin/del_item.php", {
                del_items: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.stocks.jslist.toggleOut();
                console.log(response);
                $scope.stocks.jslist.createList();
                $scope.stocks.jslist.toggleIn();
            });
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
        discount: {
            selected_discount: "item"
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

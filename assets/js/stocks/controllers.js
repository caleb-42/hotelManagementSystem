stocksApp.controller("stocks", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
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
                $rootScope.settings.modal.msg = response;
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
                $rootScope.settings.modal.msg = response;
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
            selected_discount: "item",
            itemlist: function (type) {
                if(type == "total"){
                    prod ="all";
                }else{
                    prod = $scope.stocks.jslist.selectedObj ? $scope.stocks.jslist.selectedObj.item : "sprite"
                }
                url = "assets/php1/restaurant_bar/admin/list_discount.php";
                return {
                    jsonfunc: jsonPost.data(url, {
                        item: prod
                    })
                }
            },
            addDiscount: function (jsondiscount, type) {
                prod = type == "total" ? "all" : $scope.stocks.jslist.selectedObj.item;
                jsondiscount.discount_item = prod;
                console.log("new discount", jsondiscount);
                url = "assets/php1/restaurant_bar/admin/add_discount.php";
                jsonPost.data(url, {
                    new_discount: $filter('json')(jsondiscount)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $rootScope.settings.modal.msg = response;
                    $scope.details.discount.adding = false;
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            },
            updateDiscount: function (jsondiscount, type) {
                prod = type == "total" ? "all" : $scope.stocks.jslist.selectedObj.item;

                jsondiscount.discount_item = prod;
                
                jsondiscount.discount_id = $scope.details.discount.jslist.selected;
                console.log("new discount", jsondiscount);
                url = "assets/php1/restaurant_bar/admin/edit_discount.php";
                jsonPost.data(url, {
                    edit_discounts: $filter('json')(jsondiscount)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    json = JSON.parse(response);
                    $rootScope.settings.modal.msg = json[1];
                    json[0] == "OUTPUT" ? settings.modal.close() : null;
                    $scope.details.discount.adding = false;
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            },
            deleteDiscount: function () {
                jsondiscnt = {};
                jsondiscnt.discounts = [$scope.details.discount.jslist.selectedObj];
                console.log("new discount", jsondiscnt);
                jsonPost.data("assets/php1/restaurant_bar/admin/del_discount.php", {
                    del_discounts: $filter('json')(jsondiscnt)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            }
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

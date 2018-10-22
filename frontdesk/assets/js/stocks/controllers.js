stocksApp.controller("stocks", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Products: {
                name: 'Products',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
                }
            }
        },
        selected: {
            name: 'Products',
            options: {
                rightbar: {
                    present: true,
                    rightbarclass: 'w-30',
                    primeclass: 'w-70'
                }
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.productstock = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/restaurant_items.php", {})
            }
        },
        addProduct: function (jsonprod) {
            jsonprod.discount_rate = 0;
            jsonprod.discount_criteria = 0;
            jsonprod.discount_available = "";
            console.log("new product", jsonprod);

            jsonPost.data("../php1/restaurant_bar/admin/add_item.php", {
                new_item: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        updateProduct: function (jsonprod) {
            jsonprod.id = $scope.productstock.jslist.selected;
            jsonprod.new_shelf_item = "";
            console.log("new product", jsonprod);
            jsonPost.data("../php1/restaurant_bar/admin/edit_item.php", {
                update_item: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        deleteProduct: function () {
            jsonprod = {};
            jsonprod.items = [$scope.productstock.jslist.selectedObj];
            console.log("new product", jsonprod);
            jsonPost.data("../php1/restaurant_bar/admin/del_item.php", {
                del_items: $filter('json')(jsonprod)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
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
    $scope.stock = {
        /* itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/restaurant_items.php", {})
            }
        }, */
        activateStockModal : function(){
            if($scope.productstock.jslist.selectedObj.shelf_item == 'no'){
                $scope.stock.modal = 'none';
                return
            }else{
                $scope.stock.modal = 'modal';
            }; 
            $rootScope.settings.modal.active = 'Stock'; 
            $rootScope.settings.modal.name = 'Add Stock'; 
            $rootScope.settings.modal.size = 'md';
        },
        addStock: function (jsonstock) {
            jsonstock.item_id = $scope.productstock.jslist.selectedObj.id;
            
            jsonstock.item = $scope.productstock.jslist.selectedObj.item;
            
            jsonstock.category = $scope.productstock.jslist.selectedObj.category;
            
            console.log("new stock", jsonstock);
            jsonPost.data("../php1/restaurant_bar/admin/add_stock.php", {
                new_stock: $filter('json')(jsonstock)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        /* updateStock: function (jsonstock) {
            jsonstock.id = $scope.productstock.jslist.selected;
            console.log("new product", jsonstock);
            jsonPost.data("../php1/restaurant_bar/admin/edit_item.php", {
                update_item: $filter('json')(jsonstock)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        },
        deleteStock: function () {
            jsonstock = {};
            jsonstock.items = [$scope.productstock.jslist.selectedObj];
            console.log("new product", jsonstock);
            jsonPost.data("../php1/restaurant_bar/admin/del_item.php", {
                del_items: $filter('json')(jsonstock)
            }).then(function (response) {
                $scope.productstock.jslist.toggleOut();
                console.log(response);
                $scope.productstock.jslist.createList();
                $scope.productstock.jslist.toggleIn();
            });
        } */
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
            select_discount:function(type){
                $scope.details.discount.selected_discount = type;
                $scope.details.discount.jslist.createList()
            },
            itemlist: function (type) {
                if(type == "total"){
                    prod ="all";
                }else{
                    prod = $scope.productstock.jslist.selectedObj ? $scope.productstock.jslist.selectedObj.item : "sprite"
                }
                url = "../php1/restaurant_bar/admin/list_discount.php";
                return {
                    jsonfunc: jsonPost.data(url, {
                        item: prod
                    })
                }
            },
            addDiscount: function (jsondiscount, type) {
                prod = type == "total" ? "all" : $scope.productstock.jslist.selectedObj.item;
                jsondiscount.discount_item = prod;
                console.log("new discount", jsondiscount);
                url = "../php1/restaurant_bar/admin/add_discount.php";
                jsonPost.data(url, {
                    new_discount: $filter('json')(jsondiscount)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $rootScope.settings.modal.msgprompt(response);
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            },
            updateDiscount: function (jsondiscount, type) {
                prod = type == "total" ? "all" : $scope.productstock.jslist.selectedObj.item;

                jsondiscount.discount_item = prod;
                
                jsondiscount.discount_id = $scope.details.discount.jslist.selected;
                console.log("new discount", jsondiscount);
                url = "../php1/restaurant_bar/admin/edit_discount.php";
                jsonPost.data(url, {
                    edit_discounts: $filter('json')(jsondiscount)
                }).then(function (response) {
                    $scope.details.discount.jslist.toggleOut();
                    console.log(response);
                    $rootScope.settings.modal.msgprompt(response);
                    $scope.details.discount.jslist.createList();
                    $scope.details.discount.jslist.toggleIn();
                });
            },
            deleteDiscount: function () {
                jsondiscnt = {};
                jsondiscnt.discounts = [$scope.details.discount.jslist.selectedObj];
                console.log("new discount", jsondiscnt);
                jsonPost.data("../php1/restaurant_bar/admin/del_discount.php", {
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

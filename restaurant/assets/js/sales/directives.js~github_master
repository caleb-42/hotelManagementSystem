salesApp.directive('jslist', ['List', '$rootScope', function (List, $rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/sales/listTemplates.php?type=jslist',
        scope: {
            layout: "=",
            searchquery: "=",
            getlistfunc: '&'
        },
        link: function (scope, element, attrs) {
            scope.jslist = {
                addToCart: function ($index) {
                    $rootScope.$emit("addItemToCart", scope.jslist.newItemArray[$index])
                },
                createList: function () {
                    listdetails = scope.getlistfunc();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        //console.log(result);
                        scope.jslist.values = result;
                    });
                    scope.listhddata = [
                        {
                            name: "Name",
                            width: "col-6",
                        },
                        {
                            name: "Stock",
                            width: "col-3",
                        },
                        {
                            name: "Price",
                            width: "col-3",
                        }
                    ];
                    listoptions = listdetails.listjsOptions;
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.jslist.createList();
            $rootScope.$on('resetproductlist', function(evt,params){
                console.log('ewereereewee');
                scope.jslist.toggleOut();
                scope.jslist.createList();
                scope.jslist.toggleIn();
            });
        }
    };
}]);

salesApp.directive('cartitems', ['$rootScope', '$filter', 'jsonPost', function ($rootScope, $filter, jsonPost) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/sales/listTemplates.php?type=cartitems',
        scope: {
            cart: '=',
            totalcost: '&',
            discount: '='
        },
        link: function (scope, element, attrs) {
            /*scope.$watch("cartItem.quantity")*/
            scope.cartitemsOps = {
                addItemQty: function ($index, avaQty, editQty) {
                    avaQty = avaQty ? avaQty : 0;

                    scope.cart[$index].quantity >= parseInt(avaQty) && scope.cart[$index].shelf_item == 'yes' ? null : scope.cart[$index].quantity++;

                    //console.log(scope.cart);
                    scope.cartitemsOps.calc($index, avaQty);
                },
                calc: function ($index, avaQty) {
                    avaQty = avaQty ? avaQty : 0;
                    scope.cart[$index].quantity = !scope.cart[$index].quantity ? 0 : scope.cart[$index].quantity;
                    console.log(scope.cart[$index].quantity);

                    if (scope.cart[$index].quantity >= parseInt(avaQty) && scope.cart[$index].shelf_item == 'yes') { return 0 };
                    console.log(scope.discount);

                    console.log(scope.cart[$index].discount_available == "yes", scope.cart[$index].quantity >= parseInt(scope.cart[$index].discount_criteria), scope.discount == "Item");

                    jsonPost.data("../php1/restaurant_bar/restaurant_item_discount.php", {
                        item: scope.cart[$index].item,
                        current_price: scope.cart[$index].current_price,
                        quantity: scope.cart[$index].quantity
                    }).then(function (result) {
                        console.log(result);
                        if (result && scope.discount == "Item") {
                            console.log(result);
                            cost = parseInt(scope.cart[$index].current_price) * parseInt(scope.cart[$index].quantity);
                            discount_rate = result[0].discount_value;
                            discount = (parseInt(discount_rate) / 100) * cost;
                            discountedCost = cost - discount;
                            scope.cart[$index].net_cost = cost
                            scope.cart[$index].discounted_net_cost = discountedCost;
                            scope.cart[$index].discount_amount = discount;
                            //scope.cartitemsOps.netcost = cost;
                        } else {
                            console.log('result');
                            cost = parseInt(scope.cart[$index].current_price) * parseInt(scope.cart[$index].quantity);
                            scope.cart[$index].net_cost = cost
                            scope.cart[$index].discounted_net_cost = cost;
                            scope.cart[$index].discount_amount = 0;
                            scope.cartitemsOps.netcost = cost;
                        }
                        scope.totalcost();
                    });

                },
                /* recalc: async function(){
                    //scope.cart.forEach(function(elem) {
                    arr = [];
                    for(var i = 0; i < scope.cart.length; i++) {
                        await jsonPost.data("../php1/restaurant_bar/restaurant_item_discount.php", {
                            item: scope.cart[i].item,
                            current_price: scope.cart[i].current_price,
                            quantity: scope.cart[i].quantity
                        }).then(function(result){
                            if(result && scope.discount == "Item"){
                                cost = parseInt(scope.cart[i].current_price) * parseInt(scope.cart[i].quantity);
                                discount_rate = result[0].discount_value;
                                discount = (parseInt(discount_rate) / 100) * cost;
                                discountedCost = cost - discount;
                                console.log('yes', i, discountedCost, cost, discount);
                                scope.cart[i].net_cost = discountedCost
                                scope.cart[i].discounted_net_cost = discountedCost;
                                scope.cart[i].discount_amount = discount;
                                //scope.cartitemsOps.netcost = cost;
                            }else{
                                console.log('result', i);
                                cost = parseInt(scope.cart[i].current_price) * parseInt(scope.cart[i].quantity);
                                scope.cart[i].net_cost = cost
                                scope.cart[i].discounted_net_cost = cost;
                                scope.cart[i].discount_amount = 0;
                                scope.cartitemsOps.netcost = cost;
                            }
                            i == (scope.cart.length - 1) ? scope.totalcost() : null;
                        });
                            
                    };
                    
                }, */
                recalc: function () {
                    //scope.cart.forEach(function(elem) {
                    arr = [];
                    //for(var i = 0; i < scope.cart.length; i++) {
                    jsonPost.data("../php1/restaurant_bar/restaurant_items_discount.php", {
                        items: $filter('json')(scope.cart)
                    }).then(function (result) {
                        console.log(scope.cart);
                        console.log(result);
                        for (var i = 0; i < scope.cart.length; i++) {
                            if(result[i] && result[i] != 'nil' && scope.discount == "Item"){
                                cost = parseInt(scope.cart[i].current_price) * parseInt(scope.cart[i].quantity);
                                discount_rate = result[i].discount_value;
                                discount = (parseInt(discount_rate) / 100) * cost;
                                discountedCost = cost - discount;
                                console.log('yes', i, discountedCost, cost, discount);
                                scope.cart[i].net_cost = cost
                                scope.cart[i].discounted_net_cost = discountedCost;
                                scope.cart[i].discount_amount = discount;
                                //scope.cartitemsOps.netcost = cost;
                            }else{
                                console.log('result', i);
                                cost = parseInt(scope.cart[i].current_price) * parseInt(scope.cart[i].quantity);
                                scope.cart[i].net_cost = cost
                                scope.cart[i].discounted_net_cost = cost;
                                scope.cart[i].discount_amount = 0;
                                scope.cartitemsOps.netcost = cost;
                            }
                            i == (scope.cart.length - 1) ? scope.totalcost() : null;
                        };
                    });

                    //};

                },
                minusItemQty: function ($index, avaQty, editQty) {

                    scope.cart[$index].quantity > 0 ? scope.cart[$index].quantity-- : null;
                    //console.log(scope.cart.quantity);
                    scope.cartitemsOps.calc($index, avaQty);
                },
                removeFromCart: function ($index) {
                    //console.log($index);
                    $rootScope.$emit('removeItemFromCart', {
                        position: $index
                    });
                },
                aboveStock: function (sellQty, avaQty, editqty, shelf) {
                    //console.log(sellQty, avaQty);
                    avaQty = avaQty ? avaQty : 0;
                    if (parseInt(sellQty) > parseInt(avaQty) && editqty && shelf == 'yes') {
                        return true;
                    } else {
                        return false;
                    }
                },
                activateBlinkCursor: function ($event) {
                    obj = $event.currentTarget;
                    inp = $(obj).find("input");
                    inp.focus();
                    inp.select();
                    //console.log(inp);
                },
                deactivateBlinkCursor: function ($event, $index, sellQty, avaQty) {
                    obj = $event.currentTarget;
                    avaQty = avaQty ? avaQty : 0;
                    $(obj).val() == "" || (parseInt(sellQty) > parseInt(avaQty) && scope.cart[$index].shelf_item == 'yes') ? (scope.cart[$index].quantity = 0) : null;
                    scope.cartitemsOps.calc($index, avaQty)
                    //console.log($index);
                }
            };
            $rootScope.$on('calcitemtotal', function (evt, params) {
                scope.cartitemsOps.recalc();
            });
        }
    };
}]);

salesApp.directive('ordersgrid', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/sales/listTemplates.php?type=ordersgrid',
        scope: {
            ordercheck: "&"
        },
        link: function (scope, element, attrs) {
            $rootScope.$on("neworder", function (evt, params) {
                scope.order.listarray = $.extend(true, {}, params);
                arr = $.map(scope.order.listarray, function (el) {
                    return el
                });
                scope.order.list = arr;
                scope.order.list.length == 1 ? scope.ordercheck() : null;
                $(".orderRow").fadeOut(10, function () {
                    $(".orderRow").delay(700).fadeIn(100);
                }).delay(50);

            });
            $rootScope.$on("deleteorder", function (evt, params) {
                scope.order.focused = null;
                scope.order.list.length == 1 ? scope.ordercheck() : null;
                //console.log(scope.order.list[scope.order.focusedIndex]);
                scope.order.list.splice(scope.order.focusedIndex, 1);
            });
            $rootScope.$on("DeselectOrder", function (evt, params) {
                if (scope.order.focused) {
                    scope.order.focused = null;
                    $rootScope.$emit("orderDeselected", {});
                }
            });
            scope.order = {
                focus: function (ordername, index) {
                    //console.log(index);
                    if (ordername == scope.order.focused) {
                        scope.order.focused = null;
                        $rootScope.$emit("orderDeselected", {});
                    } else {
                        scope.order.focused = ordername;
                        scope.order.focusedIndex = index;
                        $rootScope.$emit("orderSelected", {
                            list: scope.order.list[index],
                            indx: index
                        });
                    }

                },
                list: []
            }
        }
    };
}]);



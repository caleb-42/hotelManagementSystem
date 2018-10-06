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
            }
            scope.jslist.createList();
        }
    };
}]);

salesApp.directive('cartitems', ['$rootScope', function ($rootScope) {
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
                    if(scope.cart[$index].quantity >= parseInt(avaQty) && scope.cart[$index].shelf_item == 'yes'){return 0};
                    console.log(scope.discount);
                    console.log(scope.cart[$index].discount_available == "yes",  scope.cart[$index].quantity >= parseInt(scope.cart[$index].discount_criteria), scope.discount == "Item");
                    if (scope.cart[$index].discount_available == "yes" && scope.cart[$index].quantity >= parseInt(scope.cart[$index].discount_criteria)) {
                        cost = parseInt(scope.cart[$index].current_price) * parseInt(scope.cart[$index].quantity);
                        scope.cart[$index].net_cost = cost
                        discount = (parseInt(scope.cart[$index].discount_rate) / 100) * cost;
                        discountedCost = cost - discount;
                        scope.cart[$index].discounted_net_cost = discountedCost;
                        scope.cart[$index].discount_amount = discount;
                        scope.cartitemsOps.netcost = discountedCost;
                    } else {
                        console.log($index);
                        cost = parseInt(scope.cart[$index].current_price) * parseInt(scope.cart[$index].quantity);
                        scope.cart[$index].net_cost = cost
                        scope.cart[$index].discounted_net_cost = cost;
                        scope.cart[$index].discount_amount = 0;
                        scope.cartitemsOps.netcost = cost;
                    }
                    scope.totalcost();
                    /* cartItem.discount_available == \'yes\' ? (cartItem.net_cost = cartitemsOps.calc(cartItem.current_price, cartItem.quantity)) : (cartItem.discounted_net_cost = cartitemsOps.calc(cartItem.current_price, cartItem.quantity))*/

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
                    //console.log($index);
                }
            };
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



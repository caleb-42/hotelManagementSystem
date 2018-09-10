salesApp.directive('jslist', ['List', '$rootScope', function (List, $rootScope) {
    return {
        restrict: 'E',
        template: '<div class="animate-switch-container h-100 pb-4" ng-switch on="layout"><div class="animate-switch h-100" ng-switch-default><div class = "itemboxhd ovflo-y h-100 w-100"><div class = "itembox " ng-repeat = "items in (jslist.newItemArray = (jslist.values | filter:searchquery))" ng-click = "jslist.addToCart($index)"><h5>{{items.item}}</h5></div></div></div><div class="animate-switch layout  pb-5 h-100"  ng-switch-when="listlayout"><div  class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in listhddata">{{hd.name}}</span></div><div class = "h-100 listbody ovflo-y " ><ul class = "list" ><li class = "itemlistrow row" ng-repeat = "items in (jslist.newItemArray = (jslist.values | filter:searchquery))" ng-click = "jslist.addToCart($index)"><span class = "itemname col-6">{{items.item}}</span><span class = "text-center stkleft col-3">{{items.current_stock}}</span><span class = "text-center itemcost col-3">{{items.current_price}}</span></li></ul></div></div></div>',

        /* */
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
        template: '<div ng-repeat = "cartItem in cart" class="cartItem-row row align-items-center pt-4"><div class = "hvr-overlay anim"><div class = "w-40 float-right row h-100 align-items-center"><i class = " col-4 fa-2x fa fa-plus blac anim" ng-click = "cartitemsOps.addItemQty($index, cartItem.current_stock, cartItem.editqty)"></i><i class = " col-4 fa-2x blac fa fa-minus anim" ng-click = "cartitemsOps.minusItemQty($index, cartItem.current_stock, cartItem.editqty)"></i><i class = "col-4 blac fa-2x fa fa-times anim" ng-click = "cartitemsOps.removeFromCart($index)"></i></div></div><div class="col-3 m-0  align-items-start" style = "margin-bottom:20px !important;"><div class="cartItem-img"><button class="cartItem-num anim" ng-class = "{\'cartItem-numAlign\' : cartItem.editqty}" ng-style = "{\'background\' : cartitemsOps.aboveStock(cartItem.quantity, cartItem.current_stock, cartItem.editqty) ? \'red\' : \'#49B756\'}" ng-click = "cartItem.editqty =  true; cartitemsOps.activateBlinkCursor($event);"><p ng-class = "{\'gone\' : cartItem.editqty}">{{cartItem.quantity}}</p><input  maxlength = "6" ng-blur = "cartItem.editqty =  false; cartitemsOps.deactivateBlinkCursor($event, $index,cartItem.quantity, cartItem.current_stock); totalcost()"  ng-class = "{\'vanish\' : !cartItem.editqty}" ng-model = "cartItem.quantity" ng-change = "cartitemsOps.calc($index); "/></button></div></div><div class="col-9 m-0 row px-1 h-100 pt-2 align-items-center nav-tabs pb-4"><div class="col-7 row px-0 h-100 align-items-center"><div><h6 class="m-0 font-fam-Montserrat w-100 excerpt font-weight-bold opac-70">{{cartItem.item}}</h6><p class="m-0 font-fam-Myriad opac-50 f-13 excerpt">{{cartItem.description}}</p></div></div><div class="h-100 col-5 row  justify-content-center align-items-center"><h6 class="itemCost h-100 m-0 w-100 text-center font-fam-Montserrat opac-50">{{discount == "Total" ? cartItem.net_cost : cartItem.discounted_net_cost}}</h6></div></div></div>',
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
                    scope.cart[$index].quantity >= parseInt(avaQty) ? null : scope.cart[$index].quantity++;
                    //console.log(scope.cart);
                    scope.cartitemsOps.calc($index);
                },
                calc: function ($index) {
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
                    scope.cartitemsOps.calc($index);
                },
                removeFromCart: function ($index) {
                    //console.log($index);
                    $rootScope.$emit('removeItemFromCart', {
                        position: $index
                    });
                },
                aboveStock: function (sellQty, avaQty, editqty) {
                    //console.log(sellQty, avaQty);
                    avaQty = avaQty ? avaQty : 0;
                    if (parseInt(sellQty) > parseInt(avaQty) && editqty) {
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
                    $(obj).val() == "" || parseInt(sellQty) > parseInt(avaQty) ? (scope.cart[$index].quantity = 0) : null;
                    //console.log($index);
                }
            };
        }
    };
}]);

salesApp.directive('ordersgrid', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div class = "orderRow h-100" ><div ng-click = "order.focus(gridorders.buyer.name, $index)" class = "anim pdiv pointer" ng-repeat = "gridorders in order.list"><div class = \'  anim row justify-content-center align-items-center\'  ng-class = "{\'divfocus\' : order.focused  == gridorders.buyer.name, \'adiv\' : order.focused  != gridorders.buyer.name}"><h6>{{gridorders.buyer.name}}</h6></div></div></div>',
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



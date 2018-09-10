salesApp.controller("sales", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
        $scope.tabnav = {
            selected: 'Sales',
            navs: {
                nav1: {
                    name: 'Sales'
                },
                /*nav2: {
                    name: 'History'
                }*/
            },
            selectNav: function (navname) {
                $scope.tabnav.selected = navname;
            }
        };
        $scope.sales = {
            products: {
                layout: "listlayout",
                itemlist: function () {
                    return {
                        jsonfunc: jsonPost.data("assets/php1/restaurant_bar/restaurant_items.php", {}) 
                    }
                }
            },
            order: {
                panel: false,
                togglepanel: function () {
                    $scope.sales.order.panel = $scope.sales.order.panel ? false : true;
                    $rootScope.$emit("DeselectOrder", {});
                },
                checkOrderExist: function () {
                    $scope.sales.order.orderExist = $scope.sales.order.orderExist ? false : true;
                },
                command: function () {
                    $scope.sales.order.orderDeselect ? $scope.sales.order.open() : $scope.sales.order.delete();
                },
                currentCart : {
                    
                },
                delete: function () {
                    $rootScope.$emit("deleteorder", {});
                    $scope.sales.order.orderDeselect = true;
                    $scope.cart.currentCart = null;
                    $scope.sales.order.list.splice(parseInt($scope.sales.order.focused), 1);
                    $scope.cart.currentCart = $scope.cart.waitCart;
                    $scope.cart.toggleCart();
                },
                open: function () {
                    if ($scope.buyer.customer.selected.name != "Buyer") {
                        newOrder = {};
                        checklist = true;
                        $scope.sales.order.list.forEach(function (element) {
                            if ($scope.buyer.customer.selected.name == element.buyer.name) {
                                checklist = false;
                            }
                        });

                        if (checklist) {
                            newOrder.buyer = $scope.buyer.customer.selected;
                            newOrder.cart = $scope.cart.cartlist.slice(0);
                            $scope.sales.order.list.push(newOrder);
                            console.log($scope.sales.order.list);
                            $rootScope.$emit("neworder", $scope.sales.order.list);
                        };
                    }
                },
                list: [],
                orderDeselect: true
            }
        };

        $rootScope.$on("addItemToCart", function (evt, params) {
            params.editqty = false;
            params.quantity = 0;
            params.net_cost = 0;
            params.discounted_net_cost = 0;
            params.discount_amount = 0;
           /* params.sold_by = $rootScope.settings.user;*/
            /*console.log(params);*/
            itemInList = false;
            $scope.cart.cartlist.forEach(function (element) {
                //console.log(element);
                if (element.item === params.item) {
                    itemInList = true;
                    return 0;
                }
            });
            !itemInList ? $scope.cart.cartlist.push(params) : null;
        });
        $rootScope.$on("removeItemFromCart", function (evt, params) {
            console.log(params);
            $scope.cart.cartlist.splice(params.position, 1);
            $scope.surcharge.CalcCosts();
        });

        $rootScope.$on("orderSelected", function (evt, params) {
            if ($scope.sales.order.orderDeselect) {
                trolley = {};
                trolley.buyer = $scope.buyer.customer.selected;
                trolley.cart = $scope.cart.cartlist.slice();
                //$scope.sales.order.waitCart = trolley;
                $scope.cart.waitCart = trolley;
                $scope.sales.order.orderDeselect = false;
            }
            console.log(params);
            $scope.cart.currentCart = params.list;
            $scope.sales.order.focused = params.indx;
            $scope.cart.toggleCart();
        });
        $rootScope.$on("orderDeselected", function (evt, params) {
            $scope.sales.order.orderDeselect = true;
            console.log("params");
            $scope.cart.currentCart = $scope.cart.waitCart;
            $scope.cart.toggleCart();
        });
        $scope.$watch("surcharge.discount.type", function (newValue) {
            $scope.surcharge.CalcCosts();
        });

        $scope.buyer = {
            showPanel: "search",
            customer: {
                new: {
                    sex: "male"
                },
                selectedDefault: {
                    name: "Buyer",
                    sex: 'male',
                    type: "visitor",
                    bal: "0"
                },
                selected: {
                    name: "Buyer",
                    sex: 'male',
                    type: "visitor",
                    bal: "0"
                },
                selectCustomer: function (cust) {
                    $scope.buyer.customer.selected = cust;
                    console.log($scope.buyer.customer.selected);
                },
                customerList: [
                    {
                        name: "tego",
                        phone: "08130249102",
                        address: "",
                        bal: 1350,
                        sex: "male",
                        room: 5,
                        type: "customer"
                    },
                    {
                        name: "ewere",
                        phone: "08130249102",
                        address: "",
                        bal: 1350,
                        sex: "male",
                        room: 16,
                        type: "customer"
                    },
                    {
                        name: "janet",
                        phone: "08130249102",
                        address: "",
                        bal: 1350,
                        sex: "female",
                        room: 7,
                        type: "customer"
                    }
                ],
                makeCustomer : function () {
                    jsonForm = $scope.buyer.customer.jsonform("customer");
                    if (jsonForm.name == "Buyer") {
                        return 0;
                    }
    
                    if ($scope.buyer.showPanel == "addnew") {
                        $scope.buyer.customer.customerList.push(jsonForm);
                        $scope.buyer.customer.selected = jsonForm;;
                    }
                },
                getLodgers: function (request, response) {
                    data = [];
                    json1 = [
                        {
                            name: "martins",
                            phone: "08130249102",
                            address: "",
                            bal: 1350,
                            sex: "male",
                            room: 5,
                            type: "customer"
                        },
                        {
                            name: "yoma",
                            phone: "08130249102",
                            address: "",
                            bal: 1350,
                            sex: "male",
                            room: 16,
                            type: "customer"
                        },
                        {
                            name: "debby",
                            phone: "08130249102",
                            address: "",
                            bal: 1350,
                            sex: "female",
                            room: 7,
                            type: "customer"
                        }
                    ];
                    json = $filter('filter')(json1, request.term);
                    for (var a = 0; a < json.length; a++) {
                        data.push(json[a].name)
                    }
                    response(data);
                }
            }
        };

        $scope.cart = {
            cartlist: [],
            toggleCart: function () {
                $scope.buyer.customer.selected = $scope.cart.currentCart.buyer;
                $scope.cart.cartlist = $scope.cart.currentCart.cart;
                console.log( $scope.cart.currentCart);
                $scope.surcharge.CalcCosts();
            },
            currentCart : {}
        };

        $scope.surcharge = {
            TotalItemCost: 0,
            CalcCosts: function () {
                Total = 0;
                if ($scope.surcharge.discount.type == "Total") {
                    //console.log($scope.surcharge.discount);
                    tot = 0;
                    $scope.cart.cartlist.forEach(function (element) {
                        netCost =  element.net_cost;
                        console.log(netCost);
                        tot += parseInt(netCost);
                    });
                    cost = tot;
                    console.log(tot);
                    jsonPost.data("assets/php1/restaurant_bar/restaurant_discount.php", {
                        net_cost: cost
                    }).then(function (response) {
                        if (response) {
                            discount_rate = response[0].discount_value;
                            discount = (parseInt(discount_rate) / 100) * tot;
                            discountedCost = tot - discount;

                            $scope.cart.currentCart.total = {
                                transaction_discount : parseInt(discount_rate),
                                total_cost: cost,
                                discounted_total_cost : discountedCost,
                                discount_amount : discount
                            } 
                            
                            Total = discountedCost;
                        } 
                        else {
                            Total = tot;
                            $scope.cart.currentCart.total = {
                                transaction_discount : 0,
                                total_cost: Total,
                                discounted_total_cost : Total,
                                discount_amount : 0
                            } 
                        };
                        $scope.surcharge.TotalItemCost = Total >= 0 ? Total : 0;
                    });
                } else if ($scope.surcharge.discount.type == "Item") {
                    //console.log($scope.surcharge.discount);
                    $scope.cart.cartlist.forEach(function (element) {
                        Total += parseInt(element.discounted_net_cost);
                    });
                    $scope.surcharge.TotalItemCost = Total >= 0 ? Total : 0;
                };

                console.log($scope.surcharge.TotalItemCost);
            },
            discount: {
                type: "Total",
            },
            payment : {
                preview : function (){
                    $scope.cart.currentCart.buyer =  $scope.buyer.customer.selected;
                    $scope.cart.currentCart.cart = JSON.parse(JSON.stringify($scope.cart.cartlist));
                    $scope.surcharge.reciept = {
                        customer : $scope.cart.currentCart.buyer.name,
                        sales_rep : $rootScope.settings.user,
                        transaction_discount : $scope.cart.currentCart.total.transaction_discount,
                        discount_type : $scope.surcharge.discount.type,
                        total_cost : $scope.cart.currentCart.total.total_cost,
                        discount_amount : $scope.cart.currentCart.total.discount_amount,
                        discounted_total_cost : $scope.cart.currentCart.total.discounted_total_cost,
                        item_list : $scope.cart.currentCart.cart
                    }
                    console.log($scope.surcharge.reciept);
                }
            }
        }
    }]);

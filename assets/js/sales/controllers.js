salesApp.controller("primehd", ["$rootScope", "$scope", "$route", 'jsonPost', function ($rootScope, $scope, $route, jsonPost) {
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
        $scope.searchbox = {
            iconhover: true
        };
        $scope.sales = {
            products: {
                layout: "listlayout",
                itemlist: function () {
                    return {
                        jsonfunc: jsonPost.data("assets/php1/restaurant_bar/restaurant_items.php", {}) /*$scope.sales.products.data*/
                    }
                }
            },
            order: {
                panel: false,
                togglepanel: function () {
                    $scope.sales.order.panel = $scope.sales.order.panel ? false : true;
                    $rootScope.$emit("DeselectOrder", {});
                },
                orderExist: false,
                checkOrderExist: function () {
                    $scope.sales.order.orderExist = $scope.sales.order.orderExist ? false : true;
                }
            }
        };
    }])
    .controller("rightsidebar", ["$rootScope", "$scope", "$route", 'jsonPost', '$filter', function ($rootScope, $scope, $route, jsonPost,$filter) {
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
            if ($scope.surcharge.order.orderSelect) {
                newOrder = {};
                newOrder.buyer = $scope.buyer.customer.selected;
                newOrder.cart = $scope.cart.cartlist.slice(0);
                $scope.surcharge.order.waitCart = newOrder;
                $scope.surcharge.order.orderSelect = false;
            }
            console.log(params);
            $scope.surcharge.order.currentCart = null;
            $scope.surcharge.order.currentCart = params.list;
            $scope.surcharge.order.focused = params.indx;
            $scope.surcharge.order.toggleCart();
        });
        $rootScope.$on("orderDeselected", function (evt, params) {
            $scope.surcharge.order.orderSelect = true;
            console.log("params");
            $scope.surcharge.order.currentCart = null;
            $scope.surcharge.order.currentCart = $scope.surcharge.order.waitCart;
            $scope.surcharge.order.toggleCart();
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
                    //console.log(jsonForm);
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
            cartlist: []
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

                            $scope.surcharge.order.currentCart.total = {
                                transaction_discount : parseInt(discount_rate),
                                total_cost: cost,
                                discounted_total_cost : discountedCost,
                                discount_amount : discount
                            } 
                            
                            Total = discountedCost;
                        } 
                        else {
                            Total = tot;
                            $scope.surcharge.order.currentCart.total = {
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
            reciept : {
                
            },
            order: {
                command: function () {
                    $scope.surcharge.order.orderSelect ? $scope.surcharge.order.open() : $scope.surcharge.order.delete();
                },
                currentCart : {
                    
                },
                delete: function () {
                    $rootScope.$emit("deleteorder", {});
                    $scope.surcharge.order.orderSelect = true;
                    $scope.surcharge.order.currentCart = null;
                    $scope.surcharge.order.list.splice(parseInt($scope.surcharge.order.focused), 1);
                    $scope.surcharge.order.currentCart = $scope.surcharge.order.waitCart;
                    $scope.surcharge.order.toggleCart();
                },
                open: function () {
                    if ($scope.buyer.customer.selected.name != "Buyer") {
                        newOrder = {};
                        checklist = true;
                        $scope.surcharge.order.list.forEach(function (element) {
                            if ($scope.buyer.customer.selected.name == element.buyer.name) {
                                checklist = false;
                            }
                        });

                        if (checklist) {
                            newOrder.buyer = $scope.buyer.customer.selected;
                            newOrder.cart = $scope.cart.cartlist.slice(0);
                            $scope.surcharge.order.list.push(newOrder);
                            console.log($scope.surcharge.order.list);
                            $rootScope.$emit("neworder", $scope.surcharge.order.list);
                        };
                    }
                },
                list: [],
                toggleCart: function () {
                    $scope.buyer.customer.selected = $scope.surcharge.order.currentCart.buyer;
                    $scope.cart.cartlist = $scope.surcharge.order.currentCart.cart;
                    console.log( $scope.surcharge.order.currentCart);
                    $scope.surcharge.CalcCosts();
                },
                orderSelect: true
            },
            payment : {
                preview : function (){
                    $scope.surcharge.order.currentCart.buyer =  $scope.buyer.customer.selected;
                    $scope.surcharge.order.currentCart.cart = JSON.parse(JSON.stringify($scope.cart.cartlist));
                    $scope.surcharge.reciept.customer = $scope.buyer.customer.selected.name;
                    $scope.surcharge.reciept.sales_rep = $rootScope.settings.user;
                    //reciept.customer_ref = ;
                    $scope.surcharge.reciept.transaction_discount = $scope.surcharge.order.currentCart.total.transaction_discount;
                    $scope.surcharge.reciept.discount_type = $scope.surcharge.discount.type;
                    $scope.surcharge.order.currentCart.total.transaction_discount;
                    //reciept.amount_paid = ;
                    $scope.surcharge.reciept.total_cost = $scope.surcharge.order.currentCart.total.total_cost;
                    $scope.surcharge.reciept.discount_amount = $scope.surcharge.order.currentCart.total.discount_amount;
                    $scope.surcharge.reciept.discounted_total_cost = $scope.surcharge.order.currentCart.total.discounted_total_cost;
                    //reciept.pay_method = ;
                    $scope.surcharge.reciept.item_list = $scope.surcharge.order.currentCart.cart;
                    console.log($scope.surcharge.reciept);
                }
            }
        }
    }]);

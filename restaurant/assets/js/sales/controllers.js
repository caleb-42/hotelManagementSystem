salesApp.controller("sales", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Sales: {
                name: 'Sales',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
                }
            },
            /* History: {
                name: 'History',
                options: {
                    rightbar: false
                }
            } */
        },
        selected: {
            name: 'Sales',
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
    $scope.sales = {
        makeCustomerList: function () {
            cp = jsonPost.data("../php1/restaurant_bar/restaurant_customer.php", {});
            cp.then(function (result) {
                if (!result) {
                    return;
                }
                result.forEach(function (elm) {
                    elm.type = 'customer';
                    elm.room = 'none';
                });
                $scope.sales.cust_list = result;
                console.log($scope.sales.cust_list);
            });
            /* gp = jsonPost.data("../php1/front_desk/list_guests.php", {});
            gp.then(function(result){
                if(!result){
                    return;
                }
                cust_list = [];
                result.forEach(function(elm){
                    obj = {};
                    obj.customer_id = elm.guest_id;
                    obj.full_name = elm.guest_name;
                    obj.gender = elm.guest_type_gender;
                    obj.phone_number = elm.contact_address;
                    obj.contact_address = elm.contact_address;
                    obj.outstanding_balance = elm.restaurant_outstanding;
                    cust_list.push(obj);
                });
                $scope.sales.lodger_list = cust_list;
                console.log($scope.sales.lodger_list);
            }); */
        },
        products: {
            layout: "listlayout",
            itemlist: function () {
                $scope.sales.makeCustomerList();
                return {
                    jsonfunc: jsonPost.data("../php1/restaurant_bar/restaurant_items.php", {})
                }
            },
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
            currentCart: {

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
                if ($scope.buyer.customer.selected.full_name != "Buyer") {
                    newOrder = {};
                    checklist = true;
                    $scope.sales.order.list.forEach(function (element) {
                        if ($scope.buyer.customer.selected.full_name == element.buyer.full_name) {
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
        params.sold_by = $rootScope.settings.user;
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
        //$scope.surcharge.CalcCosts();
        $rootScope.$emit('calcitemtotal', {});
    });

    $scope.buyer = {
        showPanel: "search",
        customer: {
            new: {
                gender: "male"
            },
            selectedDefault: {
                full_name: "Buyer",
                gender: 'male',
                type: "visitor",
                outstanding_balance: "0",
                customer_id: 'BUYER'
            },
            selected: {
                full_name: "Buyer",
                gender: 'male',
                type: "visitor",
                outstanding_balance: "0",
                customer_id: 'BUYER'
            },
            selectCustomer: function (cust) {
                $scope.buyer.customer.selected = cust;
                console.log($scope.buyer.customer.selected);
            },
            makeCustomerList: function () {
                $scope.buyer.customer.customerList = $scope.sales.cust_list;
                console.log($scope.buyer.customer.customerList);
            },
            /* customerList, */
            makeCustomer: function () {
                jsonForm = $scope.buyer.customer.jsonform("customer");
                if (jsonForm.full_name == "Buyer") {
                    return 0;
                }

                if ($scope.buyer.showPanel == "addnew") {
                    //$scope.buyer.customer.customerList.push(jsonForm);
                    jsonPost.data("../php1/restaurant_bar/add_customer.php", {
                        new_customer: $filter('json')(jsonForm)
                    }).then(function (result) {
                        console.log(result);
                        $scope.sales.makeCustomerList();
                    });
                    $scope.buyer.customer.selected = jsonForm;;
                }
            },
            getLodgers: function (request, response) {
                data = [];
                json1 = [
                    {
                        full_name: "martins",
                        phone_number: "08130249102",
                        contact_address: "",
                        outstanding_balance: 1350,
                        gender: "male",
                        room: 5,
                        type: "customer"
                    },
                    {
                        full_name: "yoma",
                        phone_number: "08130249102",
                        contact_address: "",
                        outstanding_balance: 1350,
                        gender: "male",
                        room: 16,
                        type: "customer"
                    },
                    {
                        full_name: "debby",
                        phone_number: "08130249102",
                        contact_address: "",
                        outstanding_balance: 1350,
                        gender: "female",
                        room: 7,
                        type: "customer"
                    }
                ];
                json = $filter('filter')(json1, request.term);
                for (var a = 0; a < json.length; a++) {
                    data.push(json[a].full_name)
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
            console.log($scope.cart.currentCart);
            $scope.surcharge.CalcCosts();
        },
        currentCart: {}
    };

    $scope.surcharge = {
        TotalItemCost: 0,
        totalClass: false,
        CalcCosts: function () {
            Total = 0;
            if ($scope.surcharge.discount.type == "Total") {
                //console.log($scope.surcharge.discount);
                tot = 0;
                $scope.cart.cartlist.forEach(function (element) {
                    netCost = element.discounted_net_cost;
                    console.log(netCost);
                    tot += parseInt(netCost);
                });
                cost = tot;
                console.log(tot);
                jsonPost.data("../php1/restaurant_bar/restaurant_discount.php", {
                    net_cost: cost
                }).then(function (response) {
                    if (response) {
                        console.log(response);
                        discount_rate = response[0].discount_value;
                        discount = (parseInt(discount_rate) / 100) * tot;
                        discountedCost = tot - discount;

                        $scope.cart.currentCart.total = {
                            transaction_discount: parseInt(discount_rate),
                            total_cost: cost,
                            discounted_total_cost: discountedCost,
                            discount_amount: discount
                        }

                        Total = discountedCost;
                    }
                    else {
                        Total = tot;
                        $scope.cart.currentCart.total = {
                            transaction_discount: 0,
                            total_cost: Total,
                            discounted_total_cost: Total,
                            discount_amount: 0
                        }
                    };
                    $scope.surcharge.TotalItemCost = Total >= 0 ? Total : 0;
                });
            } else if ($scope.surcharge.discount.type == "Item") {
                //console.log($scope.surcharge.discount);
                $scope.cart.cartlist.forEach(function (element) {
                    Total += parseInt(element.discounted_net_cost);
                });
                $scope.cart.currentCart.total = {
                    transaction_discount: 0,
                    total_cost: Total,
                    discounted_total_cost: Total,
                    discount_amount: 0
                }
                $scope.surcharge.TotalItemCost = Total >= 0 ? Total : 0;
            } else if ($scope.surcharge.discount.type == "None") {
                //console.log($scope.surcharge.discount);
                $scope.cart.cartlist.forEach(function (element) {
                    Total += parseInt(element.discounted_net_cost);
                });
                $scope.cart.currentCart.total = {
                    transaction_discount: 0,
                    total_cost: Total,
                    discounted_total_cost: Total,
                    discount_amount: 0
                }
                $scope.surcharge.TotalItemCost = Total >= 0 ? Total : 0;
            };

            console.log($scope.surcharge.TotalItemCost);
        },
        discount: {
            type: "None",
        },
        payment: {
            preview: function () {
                $scope.buyer.customer.makeCustomerList();
                $scope.cart.currentCart.buyer = $scope.buyer.customer.selected;
                $scope.cart.currentCart.cart = JSON.parse(JSON.stringify($scope.cart.cartlist));
                $scope.surcharge.reciept = {
                    customer: $scope.cart.currentCart.buyer.full_name,
                    sales_rep: $rootScope.settings.user,
                    transaction_discount: $scope.cart.currentCart.total.transaction_discount,
                    discount_type: $scope.surcharge.discount.type,
                    total_cost: $scope.cart.currentCart.total.total_cost,
                    discount_amount: $scope.cart.currentCart.total.discount_amount,
                    discounted_total_cost: $scope.cart.currentCart.total.discounted_total_cost,
                    item_list: $scope.cart.currentCart.cart,
                    pay_method: 'Cash'
                }
            },
            receiptPrint: function () {
                if (!$scope.surcharge.reciept.amount_paid) {
                    $rootScope.settings.modal.msgprompt(['ERROR', 'FILL AMOUNT PAID']);
                    console.log('what');
                    return;
                }
                console.log($scope.buyer.customer.customerList);
                if ($scope.cart.currentCart.buyer.type == 'customer') {
                    $scope.buyer.customer.customerList.forEach(function (elm) {
                        console.log(elm);
                        if (elm.full_name == $scope.surcharge.reciept.customer) {
                            $scope.surcharge.reciept.customer_ref = elm.customer_id;
                        }
                    });
                } else {
                    $scope.surcharge.reciept.customer_ref = "BUYER";
                }
                console.log($scope.surcharge.reciept);
                jsonPost.data("../php1/restaurant_bar/restaurant_receipt.php", {
                    sales_details: $filter('json')($scope.surcharge.reciept)
                }).then(function(response){
                    console.log(response);
                    $rootScope.settings.modal.msgprompt(response);
                    if(!$scope.sales.order.orderDeselect){
                        $scope.sales.order.delete();
                    }else{
                        $scope.buyer.customer.selected = $scope.buyer.customer.selectedDefault;
                        $scope.cart.cartlist = []
                        $scope.cart.currentCart = {};

                    }
                });
                $rootScope.$emit('resetproductlist' , {});
            }
        }
    }
}]);

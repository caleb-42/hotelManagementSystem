app.directive('jslist', ['List', '$rootScope', function (List, $rootScope) {
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
                        /* scope.jslist.values = [
                             {
                                 category: "alcohol",
                                 current_price: "300",
                                 current_stock: "30",
                                 description: "can (33cl)",
                                 discount_available: "",
                                 discount_criteria: "0",
                                 discount_rate: "0",
                                 id: "1",
                                 item: "heineken",
                                 last_stock_update: "0000-00-00 00:00:00",
                                 reg_date: "2018-07-25 13:56:22",
                                 shelf_item: "yes",
                                 type: "beer"
                             },
                             {
                                 category: "drinks",
                                 current_price: "200",
                                 current_stock: "20",
                                 description: "plastic (33cl)",
                                 discount_available: "",
                                 discount_criteria: "7",
                                 discount_rate: "25",
                                 id: "2",
                                 item: "fanta",
                                 last_stock_update: "2018-08-10 20:38:06",
                                 reg_date: "2018-07-25 13:58:25",
                                 shelf_item: "yes",
                                 type: "soft drink"
                             },
                             {
                                 category: "snacks",
                                 current_price: "1200",
                                 current_stock: null,
                                 description: "medium",
                                 discount_available: "",
                                 discount_criteria: "0",
                                 discount_rate: "0",
                                 id: "3",
                                 item: "sharwama",
                                 last_stock_update: "0000-00-00 00:00:00",
                                 reg_date: "2018-07-28 13:34:06",
                                 shelf_item: "no",
                                 type: "chicken"
                             },
                             {
                                 category: "snacks",
                                 current_price: "1000",
                                 current_stock: null,
                                 description: "medium",
                                 discount_available: "",
                                 discount_criteria: "0",
                                 discount_rate: "0",
                                 id: "4",
                                 item: "hot-dog",
                                 last_stock_update: "0000-00-00 00:00:00",
                                 reg_date: "2018-07-28 13:37:18",
                                 shelf_item: "no",
                                 type: "beef"
                             }
                         ];*/
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

app.directive('cartitems', ['$rootScope', function ($rootScope) {
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

app.directive('ordersgrid', ['$rootScope', function ($rootScope) {
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
                //scope.order.list = Object.values(scope.order.listarray);
                //console.log(scope.order.list);
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
/*`
<div class = "BuyerPanel px-4 my-4 w-100" ng-switch on = 'buyer.showPanel'> 

<div ng-switch-when = 'addnew' class = "addNew">

<div class = "d-block w-100 text-center buysec"><i class="fa  d-inline-block {{buyer.customer.new.sex == \'male\' ? \'avatar-img\' : \'avatar-img-female\'}}"></i></div>

<form autocomplete = "off" class = "custform w-100 text-center mt-2 px-5 ">
<input  class = " form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block" placeholder = "Name" name = "name"  ng-focus = "activateAutoComplete($event)"/>
<input class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block" placeholder = "Phone Number"   name = "phone"/>
<input class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block" placeholder = "Address"  name = "address" />
<input type = "number" onkeydown = "javascript: return event.keyCode !=69" class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block" placeholder = "Room"   name = "room"/>
<div class = "w-50 d-inline-block px-5 mt-3">
<span class = "float-left"><input type = "radio" id = "male" name = "sex" value = "male" ng-model = "buyer.customer.new.sex"/><label class = "ml-2 d-inline-block pointer" for = "male">Male</label></span>

<span class = "float-right"><input type = "radio" id = "female" name = "sex" value = "female" ng-model = "buyer.customer.new.sex"/><label class = "ml-2 d-inline-block pointer" for = "female">Female</label></span>
</div>
</form>
</div>

<div ng-switch-when = 'search' class = "customerPanel font-fam-Montserrat">

<div class = "searchPanel float-left w-50 pl-2 pr-3">
<div><input class = "form-control customer-search m-0 w-100" ng-model = "searchquery"/></div>
<div class = "custlist w-100 mt-3 pb-4">
<div class = "custlisthd w-100 px-3 py-1 wht grn"><div class = "d-inline-block w-75">Name</div><div class = "d-inline-block w-25">Balance</div></div>
<div class = "ul-con h-100" style = "overflow-y:auto;">
<ul class = "w-100">
<li ng-click = "buyer.customer.selectCustomer(cust)" ng-style = "{\'background\' : cust.name == buyer.customer.selected.name ? \'#ccc\': null}" ng-repeat = "cust in buyer.customer.customerList | filter:searchquery" class = "w-100 px-3 py-1 f-13"><div class = "d-inline-block w-75">{{cust.name}}</div><div class = "d-inline-block w-25">{{cust.bal}}</div></li>
</ul>
</div>
</div>
</div>
<div class = "historyPanel float-right w-50 pl-3 pr-2">
<div class="w-100 row justify-content-between align-items-center">
<div class = "col-4 buysec"><i class="fa {{buyer.customer.selected.sex == \'male\' ? \'avatar-img\' : \'avatar-img-female\'}}"></i></div>
<h3 class = "col-8">{{buyer.customer.selected.name}}</h3>
</div>
<div class = "row w-100">
<div class = "col-4 my-3 opac-50  pl-4">Room</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.room}}</div>
<div class = "col-4 my-3 opac-50  pl-4">Phone</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.phone}}</div>
<div class = "col-4 my-3 opac-50  pl-4">Address</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.address}}</div>
</div>
</div>
<div class = "clr"></div>
</div>

</div>
`*/
app.directive('customerentry', ['$rootScope', 'jsonPost', '$filter', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        template: `<div ng-if = "settings.modal.active == \'customer\'"><div class = "BuyerPanel px-4 my-4 w-100" ng-switch on = \'buyer.showPanel\'><div ng-switch-when = \'addnew\' class = "addNew"><div class = "d-block w-100 text-center buysec"><i class="fa  d-inline-block {{buyer.customer.new.sex == \'male\' ? \'avatar-img\' : \'avatar-img-female\'}}"></i></div><form autocomplete = "off" class = "custform w-100 text-center mt-2 px-5 "><input  class = " form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Name" name = "name"  ng-focus = "activateAutoComplete($event)"/><input class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Phone Number"   name = "phone"/><input class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Address"  name = "address" /><input type = "number" onkeydown = "javascript: return event.keyCode !=69" class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Room"   name = "room"/><div class = "w-50 d-inline-block px-5 mt-3"><span class = "float-left"><input type = "radio" id = "male" name = "sex" value = "male" ng-model = "buyer.customer.new.sex"/><label class = "ml-2 d-inline-block pointer" for = "male">Male</label></span><span class = "float-right"><input type = "radio" id = "female" name = "sex" value = "female" ng-model = "buyer.customer.new.sex"/><label class = "ml-2 d-inline-block pointer" for = "female">Female</label></span></div></form></div><div ng-switch-when = \'search\' class = "customerPanel font-fam-Montserrat"><div class = "searchPanel float-left w-50 pl-2 pr-3"><div><input class = "form-control customer-search m-0 w-100" ng-model = "searchquery"/></div><div class = "custlist w-100 mt-3 pb-4"><div class = "custlisthd w-100 px-3 py-1 wht grn"><div class = "d-inline-block w-75">Name</div><div class = "d-inline-block w-25">Balance</div></div><div class = "ul-con h-100" style = "overflow-y:auto;"><ul class = "w-100"><li ng-click = "buyer.customer.selectCustomer(cust)" ng-style = "{\'background\' : cust.name == buyer.customer.selected.name ? \'#ccc\': null}" ng-repeat = "cust in buyer.customer.customerList | filter:searchquery" class = "w-100 px-3 py-1 f-13"><div class = "d-inline-block w-75">{{cust.name}}</div><div class = "d-inline-block w-25">{{cust.bal}}</div></li></ul></div></div></div><div class = "historyPanel float-right w-50 pl-3 pr-2"><div class="w-100 row justify-content-between align-items-center"><div class = "col-4 buysec"><i class="fa {{buyer.customer.selected.sex == \'male\' ? \'avatar-img\' : \'avatar-img-female\'}}"></i></div><h3 class = "col-8">{{buyer.customer.selected.name}}</h3></div><div class = "row w-100"><div class = "col-4 my-3 opac-50  pl-4">Room</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.room}}</div><div class = "col-4 my-3 opac-50  pl-4">Phone</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.phone}}</div><div class = "col-4 my-3 opac-50  pl-4">Address</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.address}}</div></div></div><div class = "clr"></div></div></div><div class="modal-footer w-100"><div class="justify-content-center w-100 d-flex flex-column"><div class="py-1 align-self-center row justify-content-between w-40"><button type="button" class="b-0 btn btn-warning" ng-click = "buyer.customer.selected = buyer.showPanel == \'addnew\' ? buyer.customer.jsonform(\'visitor\') : buyer.customer.selectedDefault">{{buyer.showPanel == \'addnew\' ? \'Select\' : \'Reset\'}}</button><button type="button" class="b-0 btn btn-success" ng-click = "buyer.customer.makeCustomer()">Add</button><button type="button" class="btn b-0 {{buyer.showPanel == \'addnew\' ? \'btn-danger\' : \'btn-info\'}}" ng-click = "buyer.showPanel = buyer.showPanel == \'addnew\' ? \'search\' : \'addnew\'">{{buyer.showPanel == \'addnew\' ? \'Search\' : \'New\'}}</button></div></div></div></div><div ng-if = "settings.modal.active == \'payment\'"><div>
<form autocomplete="off" id="recieptForm" class = "custform w-100 text-center mt-2 px-3 ">
<div class = "buyer w-100">

<div class = "w-50 pr-1 float-left">
<div class = "w-100 py-3 row align-items-center justify-content-start">
<div class = "f-14 col-7 text-left">Customer</div><div class = "f-13 text-left opac-50  col-5">sdsgd</div>
</div>
<div class = "w-100 py-3 row align-items-center justify-content-start">
<div class = "f-14 col-7 text-left">Total Cost</div><div class = "f-13 text-left opac-50  col-5">sdsgd</div>
</div>
</div>

<div class = "w-50 pl-1 float-right">
<div class = "w-100 py-3 row align-items-center justify-content-end">
<div class = "f-14 col-7 text-left">Ref</div><div class = "f-13 text-left opac-50  col-5">sdsgd</div>
</div>
<div class = "w-100 py-3 row align-items-center justify-content-end">
<div class = "f-14 col-7 text-left">Discounted Cost</div><div class = "f-13 text-left opac-50  col-5">sdsgd</div>
</div>
</div>

</div>

<div>
<ul class = "w-100"><li ng-repeat = "prod in surcharge.reciept.item_list" class = "w-100 px-3 py-1 f-13"><div class = "d-inline-block w-75">{{prod.item}}</div><div class = "d-inline-block w-25">{{prod.quantity}}</div></li></ul>
</div>
</form>
</div><div class="modal-footer w-100 px-5"><div class="justify-content-center w-100 d-flex flex-column"><button type="button" class="b-0 btn btn-success mx-5" ng-click="">Pay</button></div> </div></div>`,
        scope: false,
        link: function (scope, element, attrs) {
            //console.log($filter);
            $.fn.serializeObject = function () {
                var formData = {};
                var formArray = this.serializeArray();

                for (var i = 0, n = formArray.length; i < n; ++i)
                    formData[formArray[i].name] = formArray[i].value;

                return formData;
            };
            scope.buyer.customer.makeCustomer = function () {
                jsonForm = scope.buyer.customer.jsonform("customer");
                if (jsonForm.name == "Buyer") {
                    return 0;
                }

                if (scope.buyer.showPanel == "addnew") {
                    scope.buyer.customer.customerList.push(jsonForm);
                    scope.buyer.customer.selected = jsonForm;;
                }
                //console.log(jsonForm);
            }
            scope.buyer.customer.jsonform = function (a) {
                jsonForm = $(".custform").serializeObject();
                jsonForm.type = a;
                jsonForm.bal = 0;
                jsonForm = $("[name = name]").val() == "" ? scope.buyer.customer.selectedDefault : jsonForm;
                $('#Customer').modal('hide');
                return jsonForm;
            }
            data = [];
            var json1;
            scope.buyer.customer.getLodgers = function (request, response) {
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
            };
            $rootScope.activateAutoComplete = function (a) {
                /*scope.buyer.customer.new.sex = "female";*/
                if (!$(a).autocomplete("instance")) {

                    $(a.currentTarget).autocomplete({
                        source: scope.buyer.customer.getLodgers,

                        select: function (event, ui) {
                            for (var p = 0; p < json1.length; p++) {
                               // console.log(json1[p].name, ui.item.label);
                                if (json1[p].name == ui.item.label) {
                                    $("input[name = phone]").val(json1[p].phone);
                                    $("input[name = address]").val(json1[p].address);
                                    $("input[name = room]").val(json1[p].room);
                                    //console.log(json1[p].sex);
                                    scope.buyer.customer.new.sex = json1[p].sex;
                                    scope.$apply();
                                    /*$("input[name = sex]").val();*/
                                }
                            }
                        }
                    });
                }
            }

            $('.modal').on('hidden.bs.modal', function () {
                scope.settings.modal.active = ""
            });
            $(".modal .close").on("click", function () {
                scope.settings.modal.active = ""
            });
        }
    };
}]);

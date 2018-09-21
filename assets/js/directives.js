var modalTemplate = `
<div class="modal-dialog modal-{{settings.modal.size}}">

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title ml-3">{{settings.modal.name}}</h5>
            <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick=" ">×</button>
        </div> 
        <div class="modal-body nopadding">

        <div ng-if = "settings.modal.active == \'customer\'"><div class = "BuyerPanel px-4 my-4 w-100" ng-switch on = \'buyer.showPanel\'><div ng-switch-when = \'addnew\' class = "addNew"><div class = "d-block w-100 text-center buysec"><i class="fa  d-inline-block {{buyer.customer.new.sex == \'male\' ? \'avatar-img\' : \'avatar-img-female\'}}"></i></div><form autocomplete = "off" class = "custform w-100 text-center mt-2 px-5 "><input  class = " form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Name" name = "name"  ng-focus = "activateAutoComplete($event)"/><input class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Phone Number"   name = "phone"/><input class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Address"  name = "address" /><input type = "number" onkeydown = "javascript: return event.keyCode !=69" class = "form-control font-fam-Montserrat w-50 mt-4 text-center d-inline-block mx-3" placeholder = "Room"   name = "room"/><div class = "w-50 d-inline-block px-5 mt-3"><span class = "float-left"><input type = "radio" id = "male" name = "sex" value = "male" ng-model = "buyer.customer.new.sex"/><label class = "ml-2 d-inline-block pointer" for = "male">Male</label></span><span class = "float-right"><input type = "radio" id = "female" name = "sex" value = "female" ng-model = "buyer.customer.new.sex"/><label class = "ml-2 d-inline-block pointer" for = "female">Female</label></span></div></form></div><div ng-switch-when = \'search\' class = "customerPanel font-fam-Montserrat"><div class = "searchPanel float-left w-50 pl-2 pr-3"><div><input class = "form-control customer-search m-0 w-100" ng-model = "searchquery"/></div><div class = "custlist w-100 mt-3 pb-4"><div class = "custlisthd w-100 px-3 py-1 wht grn"><div class = "d-inline-block w-75">Name</div><div class = "d-inline-block w-25">Balance</div></div><div class = "ul-con h-100" style = "overflow-y:auto;"><ul class = "w-100"><li ng-click = "buyer.customer.selectCustomer(cust)" ng-style = "{\'background\' : cust.name == buyer.customer.selected.name ? \'#ccc\': null}" ng-repeat = "cust in buyer.customer.customerList | filter:searchquery" class = "w-100 px-3 py-1 f-13"><div class = "d-inline-block w-75">{{cust.name}}</div><div class = "d-inline-block w-25">{{cust.bal}}</div></li></ul></div></div></div><div class = "historyPanel float-right w-50 pl-3 pr-2"><div class="w-100 row justify-content-between align-items-center"><div class = "col-4 buysec"><i class="fa {{buyer.customer.selected.sex == \'male\' ? \'avatar-img\' : \'avatar-img-female\'}}"></i></div><h3 class = "col-8">{{buyer.customer.selected.name}}</h3></div><div class = "row w-100"><div class = "col-4 my-3 opac-50  pl-4">Room</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.room}}</div><div class = "col-4 my-3 opac-50  pl-4">Phone</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.phone}}</div><div class = "col-4 my-3 opac-50  pl-4">Address</div><div class = "col-8 my-3 opac-50 ">{{buyer.customer.selected.address}}</div></div></div><div class = "clr"></div></div></div><div class="modal-footer w-100"><div class="justify-content-center w-100 d-flex flex-column"><div class="py-1 align-self-center row justify-content-between w-40"><button type="button" class="b-0 btn btn-warning" ng-click = "buyer.customer.selected = buyer.showPanel == \'addnew\' ? buyer.customer.jsonform(\'visitor\') : buyer.customer.selectedDefault">{{buyer.showPanel == \'addnew\' ? \'Select\' : \'Reset\'}}</button><button type="button" ng-class = "{\'gone\': buyer.showPanel != \'addnew\'}" class="b-0 btn btn-success" ng-click = "buyer.customer.makeCustomer()">Add</button><button type="button" class="btn b-0 {{buyer.showPanel == \'addnew\' ? \'btn-danger\' : \'btn-info\'}}" ng-click = "buyer.showPanel = buyer.showPanel == \'addnew\' ? \'search\' : \'addnew\'">{{buyer.showPanel == \'addnew\' ? \'Search\' : \'New\'}}</button></div></div></div></div>

<div ng-if = "settings.modal.active == \'payment\'">
<div>
<form autocomplete="off" id="recieptForm" class = "custform w-100 text-center mt-2 ">

<div class = "buyer w-100">
<h3 class="mb-4 opac-50 mt-3">{{surcharge.reciept.customer.name}}</h3>

<div class = "w-100 px-4 pt-3 choralback row justify-content-around wht">
<span>
<h6 class = "mb-2">Total Cost</h6>
<p>{{surcharge.reciept.total_cost}}</p>
</span>
<span>
<h6 class = "mb-2">Discount</h6>
<p>{{surcharge.reciept.discount}}</p>
</span>
<span>
<h6 class = "mb-2">Sales Rep</h6>
<p>{{surcharge.reciept.sales_rep}}</p>
</span>
</div>

</div>

<div class="my-4">
<ul class = "w-100 row justify-content-center"><li ng-repeat = "prod in surcharge.reciept.item_list" class = "w-75  py-2 f-17 row justify-content-between"><h4 class = "text-left text-light">{{prod.item}}</h4><h4 class = "text-left text-light">{{prod.quantity}}</h4></li></ul>
</div>
</form>
</div>

<div class="modal-footer w-100 px-5">
<div class="justify-content-center w-100 d-flex flex-column"><button type="button" class="b-0 btn btn-success mx-5" ng-click="">Pay</button></div>
</div>
</div>

<div ng-if = "settings.modal.active == \'Add Product\'">
                <form autocomplete="off" class="addProductForm mx-5 my-4">
                    <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="item" />
                    <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Stock" name="current_stock" />
                    <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Price" name="current_price" />
                    <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Description" name="description" />
                    <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Category" name="category" />
                    <div class="row justify-content-around my-2 align-items-center font-fam-Montserrat">
                        <h6 class="font-fam-Montserrat-bold choral">Shelf Item</h6><span><input type="radio" id = "yes" value = "yes"  name = "shelf_item"/><label for="yes" class = "f-15 ml-2">Yes</label></span><span><input type="radio" checked value = "no"  name = "shelf_item" id = "no"/><label for="no" class = "f-15 ml-2">No</label></span></div>

                    <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Type" name="type" />
                </form>
                <div class="modal-footer w-100">
                <div class="justify-content-center w-100 d-flex flex-column">
                    <div class="py-1 row justify-content-center w-100">
                        <div ng-class = "{gone : !stocks.addingProduct}"><img src = "./assets/img/loader.gif" width = "100px" height = "70px"/></div>
                        <button type="button" class="{{stocks.addingProduct ? \'gone\' : \'\'}} b-0 btn btn-success my-3" onclick="addProduct()" ng-click = "stocks.addingProduct = true">
                            Add
                        </button>
                    </div>
                </div>
                </div>
            </div>
            <div ng-if = "settings.modal.active == \'Update Product\'">
            <form autocomplete="off" class="updateProductForm"> 
                <div class="ml-5 my-4 float-left w-40 inpRead">
                  <div class="w-100">
                        <input class="item form-control font-fam-Montserrat text-center d-block my-4" placeholder="Name" value = "rer" name="item" readonly/>
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Stock" name="current_stock" readonly/>
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Price" name="current_price" readonly/>
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Description" name="description" readonly/>
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Category" name="category" readonly/>
                        <input type="text" name = "shelf_item" class="form-control font-fam-Montserrat text-center d-block my-4" readonly/>
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Type" name="type" readonly/>
                    </div>
                    </div>
                    <div class="updateProductForm mr-5 my-4 float-right w-40">
                    <div class="w-100">
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="new_item" />
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Stock" name="new_current_stock" />
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Price" name="new_current_price" />
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Description" name="new_description" />
                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Category" name="new_category" />
                        <div class="row justify-content-around my-2 align-items-center font-fam-Montserrat">
                            <h6 class="font-fam-Montserrat-bold choral">Shelf Item</h6><span><input type="radio" id = "yes" value = "yes"  name = "new_shelf_item"/><label for="yes" class = "f-15 ml-2">Yes</label></span><span><input type="radio" checked value = "no"  name = "new_shelf_item" id = "no"/><label for="no" class = "f-15 ml-2">No</label></span></div>

                        <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Type" name="new_type" />
                    </div>
                    </div>
                </form>
                <div class="modal-footer w-100">
                <div class="justify-content-center w-100 d-flex flex-column">
                    <div class="py-1 row justify-content-center w-100">
                    <div ng-class = "{gone : !stocks.updatingProduct}"><img src = "./assets/img/loader.gif" width = "100px" height = "70px"/></div>
                        <button type="button" class="{{stocks.updatingProduct ? \'gone\' : \'\'}} b-0 btn btn-success my-3" onclick="updateProduct()" ng-click = "stocks.updatingProduct = true">
                            Update
                        </button>
                    </div>
                </div>
                </div>
            </div>

            <div ng-if = "settings.modal.active == \'Discount\'">
                <div class = "w-100" ng-if = "settings.modal.name == \'Update Discount\'">
                    <div class="p-4 w-100">
                        <div class= "float-left w-45 inpRead row m-0">
                            <input class="discnt form-control font-fam-Montserrat text-center d-block my-4" placeholder="Discount" readonly/>
                            <input class="uplimit form-control font-fam-Montserrat text-center d-block my-4" placeholder="Upper Limit" readonly/>
                            <input class="lowlimit form-control font-fam-Montserrat text-center d-block my-4" placeholder="Lower Limit" readonly/>
                        </div>
                        <form class= "float-right w-45 updateDiscount row m-0">
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Discount" name = "discnt"/>
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Upper Limit" name = "uplimit"/>
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Lower Limit" name = "lowlimit"/>
                        </form>
                    </div>
                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-1 row justify-content-center w-100">
                                <div ng-class = "{gone : !details.discount.adding}"><img src = "./assets/img/loader.gif" width = "100px" height = "70px"/></div>
                                <button type="button" class="{{details.discount.adding ? \'gone\' : \'\'}} b-0 btn btn-success" onclick="UpdateDiscount()" ng-click = "details.discount.adding = true">
                                    {{settings.modal.name | limitTo:6}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "w-100" ng-if = "settings.modal.name == \'Add Discount\'">
                    <form class= "p-4 w-100 addDiscount row justify-content-center m-0">
                      <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Discount Name" name = "discount_name"/>
                      <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Lower Limit" name = "lower_limit"/>
                      <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Upper Limit" name = "upper_limit"/>
                      <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Discount Value" name = "discount_value"/>
                    </form>
                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                            <div class="py-1 row justify-content-center w-100">
                                <div ng-class = "{gone : !details.discount.adding}"><img src = "./assets/img/loader.gif" width = "100px" height = "70px"/></div>
                                <button type="button" class="{{details.discount.adding ? \'gone\' : \'\'}} b-0 btn btn-success" onclick="addDiscount()" ng-click = "details.discount.adding = true">
                                    {{settings.modal.name | limitTo:3}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100" ng-if="settings.modal.active == \'User\'">
                <div class="w-100" ng-if="settings.modal.name == \'Add User\'">
                    <form class="p-4 w-100 addUserForm row justify-content-center m-0">
                        <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="user" />
                        <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Username" name="user_name" />
                        <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Password" name="user_pass" />
                        <div class="row justify-content-between w-50">
                            <span>
                                <input type="radio" id = "admin" value = "admin"  name = "role"/>
                                <label for="admin" class = "f-15 ml-2">Admin</label>
                            </span>
                            <span>
                                <input type="radio" checked value = "user"  name = "role" id = "user"/>
                                <label for="user" class = "f-15 ml-2">User</label>
                            </span>
                        </div>
                    </form>
                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                            <div class="py-1 row justify-content-center w-100">
                                <div ng-class = "{gone : !users.adding}"><img src = "./assets/img/loader.gif" width = "100px" height = "70px"/></div>
                                <button type="button" class="{{users.adding ? \'gone\' : \'\'}} b-0 btn btn-success" onclick="addUser()" ng-click = "users.adding = true">
                                    {{settings.modal.name | limitTo:3}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100" ng-if="settings.modal.name == \'Update User\'">
                    <form autocomplete="off" class="updateUserForm p-4 w-100"> 
                        <div class= "float-left w-45 inpRead row m-0">
                            <input class="user form-control font-fam-Montserrat text-center d-block my-4" placeholder="User" name = "user" readonly/>
                            <input class="user-name form-control font-fam-Montserrat text-center d-block my-4" placeholder="Username" name = "user_name" readonly/>
                            <input class="role form-control font-fam-Montserrat text-center d-block my-4" placeholder="Role" name = "role" readonly/>
                            <input class="password form-control font-fam-Montserrat text-center d-block my-4" placeholder="Password" name = "pass" readonly/>
                        </div>
                        <div class= "float-right w-45 row m-0 justify-content-center">
                            <input class="user form-control font-fam-Montserrat text-center d-block my-4" placeholder="User" name = "new_user"/>
                            <input class="user-name form-control font-fam-Montserrat text-center d-block my-4" placeholder="Username" name = "new_user_name"/>
                            <div class="row justify-content-between w-50 py-4">
                            <span class = "py-1">
                                <input type="radio" id = "admin" value = "admin"  name = "new_role"/>
                                <label for="admin" class = "f-15 ml-2">Admin</label>
                            </span>
                            <span class = "py-1">
                                <input type="radio" checked value = "user"  name = "new_role" id = "user"/>
                                <label for="user" class = "f-15 ml-2">User</label>
                            </span>
                            </div>
                            <input class="password form-control font-fam-Montserrat text-center d-block my-4" placeholder="Password" name = "new_password"/>
                        </div>
                    </form>
                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                            <div class="py-1 row justify-content-center w-100">
                                <div ng-class = "{gone : !users.adding}"><img src = "./assets/img/loader.gif" width = "100px" height = "70px"/></div>
                            
                                <button type="button" class="{{users.adding ? \'gone\' : \'\'}} b-0 btn btn-success" onclick="updateUser()" ng-click = "users.adding = true">
                                    {{settings.modal.name | limitTo:7}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--....... User End ......... -->

        </div>
    </div>
</div>`

app.directive('modalentry', ['$rootScope', 'jsonPost', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        template: modalTemplate,
        // templateUrl: 'assetsmodals.html',
        scope: false,
        link: function (scope, element, attrs) {

            $.fn.serializeObject = function () {
                var formData = {};
                var formArray = this.serializeArray();

                for (var i = 0, n = formArray.length; i < n; ++i)
                    formData[formArray[i].name] = formArray[i].value;

                return formData;
            };
            loadJson2Form = function (json, cont) {
                for (var key in json) {
                    if(key != "$$hashKey")
                    $(cont + " input[name = " + key + "]").val(json[key]);
                }
            }
            $('.modal').on("shown.bs.modal", function () {
                if ($rootScope.settings.modal.active == "Update Product") {
                    console.log(scope.stocks);
                    loadJson2Form(scope.stocks.jslist.selectedObj, '.inpRead');
                }else if ($rootScope.settings.modal.name == "Update User") {
                    console.log(scope.users);
                    loadJson2Form(scope.users.jslist.selectedObj, '.inpRead');
                }
            });
            updateProduct = function () {
                jsonForm = $(".updateProductForm").serializeObject();
                scope.stocks.updateProduct(jsonForm);
            };
            addProduct = function () {
                jsonForm = $(".addProductForm").serializeObject();
                scope.stocks.addProduct(jsonForm);
            };
            addUser = function () {
                jsonForm = $(".addUserForm").serializeObject();
                console.log(scope.users);
                scope.users.addUser(jsonForm);
            };
            updateUser = function () {
                jsonForm = $(".updateUserForm").serializeObject();
                scope.users.updateUser(jsonForm);
            };
            addDiscount = function (){
                jsonForm = $(".addDiscount").serializeObject();
                scope.details.discount.addDiscount(scope.details.discount.selected_discount, jsonForm);
            };
            if (scope.sidebarnav.navig.activeNav == "Sales") {
                scope.buyer.customer.jsonform = function (a) {
                    jsonForm = $(".custform").serializeObject();
                    jsonForm.type = a;
                    jsonForm.bal = 0;
                    jsonForm = $("[name = name]").val() == "" ? scope.buyer.customer.selectedDefault : jsonForm;
                    $('#Customer').modal('hide');
                    return jsonForm;
                }
                $rootScope.activateAutoComplete = function (a) {
                    /*scope.buyer.customer.new.sex = "female";*/
                        console.log("json1[p].sex");
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
                                        console.log(json1[p].sex);
                                        scope.buyer.customer.new.sex = json1[p].sex;
                                        scope.$apply();
                                        /*$("input[name = sex]").val();*/
                                    }
                                }
                            }
                        });
                    }
                }
            }

            $('.modal').on('hidden.bs.modal', function(){
                $rootScope.settings.modal.active = ""
            });
            $('.modal .close').on('click', function(){
                $rootScope.settings.modal.active = ""
            });

        }
    };
}]);
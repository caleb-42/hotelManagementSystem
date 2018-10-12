app.directive('modalentry', ['$rootScope', 'jsonPost', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        //template: modalTemplate,
        templateUrl: './assets/js/modals.html',
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
                    console.log(scope.productstock);
                    loadJson2Form(scope.productstock.jslist.selectedObj, '.inpRead');
                }else if ($rootScope.settings.modal.name == "Update User") {
                    console.log(scope.users);
                    loadJson2Form(scope.users.jslist.selectedObj, '.inpRead');
                }else if ($rootScope.settings.modal.name == "Update Discount") {
                    console.log(scope.details.discount);
                    loadJson2Form(scope.details.discount.jslist.selectedObj, '.inpRead');
                }else if ($rootScope.settings.modal.name == "Update Customer") {
                    console.log(scope.customers);
                    loadJson2Form(scope.customers.jslist.selectedObj, '.inpRead');
                }
            });
            updateProduct = function () {
                jsonForm = $(".updateProductForm").serializeObject();
                scope.productstock.updateProduct(jsonForm);
            };
            addProduct = function () {
                jsonForm = $(".addProductForm").serializeObject();
                scope.productstock.addProduct(jsonForm);
            };
            addStock = function (){
                jsonForm = $(".addStockForm").serializeObject();
                scope.stock.addStock(jsonForm);
            }
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
                scope.details.discount.addDiscount(jsonForm,scope.details.discount.selected_discount );
            };
            updateDiscount = function () {
                jsonForm = $(".updateDiscount").serializeObject();
                scope.details.discount.updateDiscount(jsonForm,scope.details.discount.selected_discount);
            };
            addCustomer = function (form){
                if(form == '.addCustomersForm'){
                    jsonForm = $(form).serializeObject();
                    scope.customers.addCustomer(jsonForm);
                }
            };
            updateCustomer = function () {
                jsonForm = $(".updateCustomersForm").serializeObject();
                scope.customers.updateCustomer(jsonForm);
            };
            debtpaydata = function () {
                jsonForm = $(".debtpayForm").serializeObject();
                //console.log(jsonForm);
                scope.listtranxs.debtpay(jsonForm);
            };
            if (scope.sidebarnav.navig.activeNav == "Sales") {
                scope.buyer.customer.jsonform = function (a) {
                    jsonForm = $(".custform").serializeObject();
                    jsonForm.type = a;
                    jsonForm.outstanding_balance = 0;
                    jsonForm = $("[name = full_name]").val() == "" ? scope.buyer.customer.selectedDefault : jsonForm;
                    $('#Customer').modal('hide');
                    return jsonForm;
                }
                $rootScope.activateAutoComplete = function (a) {
                    /*scope.buyer.customer.new.sex = "female";*/
                        console.log("json1[p].gender");
                    if (!$(a).autocomplete("instance")) {
                        $(a.currentTarget).autocomplete({
                            source: scope.buyer.customer.getLodgers,

                            select: function (event, ui) {
                                for (var p = 0; p < json1.length; p++) {
                                    // console.log(json1[p].name, ui.item.label);
                                    if (json1[p].full_name == ui.item.label) {
                                        $("input[name = phone_number]").val(json1[p].phone_number);
                                        $("input[name = contact_address]").val(json1[p].contact_address);
                                        $("input[name = room]").val(json1[p].room);
                                        console.log(json1[p].gender);
                                        scope.buyer.customer.new.gender = json1[p].gender;
                                        scope.$apply();
                                        /*$("input[name = sex]").val();*/
                                    }
                                }
                            }
                        });
                    }
                }
            }
            $rootScope.settings.modal.close = function () {
                $(".report").fadeIn(300, function () {
                    $(".report").delay(3000).fadeOut(300, function(){
                        $(".modal .close").trigger("click");
                        $rootScope.settings.modal.msg = "";
                        $(".modal input").val("");
                    });
                });
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
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
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateProductForm").serializeObject();
                jsonForm.new_current_stock = "";
                scope.productstock.updateProduct(jsonForm);
            };
            addProduct = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addProductForm").serializeObject();
                //console.log();
                jsonForm.shelf_item = scope.productstock.jslist.shelfitem;
                scope.productstock.addProduct(jsonForm);
            };
            addStock = function (){
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addStockForm").serializeObject();
                if(parseInt(jsonForm.quantity) < 1 || jsonForm.quantity == ''){
                    $rootScope.settings.modal.msgprompt(['ERROR', 'FILL STOCK WITH A POSITIVE VALUE']);
                    //console.log($rootScope.settings.modal.msg);
                    $rootScope.$apply();
                    return;
                }
                scope.stock.addStock(jsonForm);
            }
            addUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addUserForm").serializeObject();
                console.log(scope.users);
                scope.users.addUser(jsonForm);
            };
            updateUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateUserForm").serializeObject();
                scope.users.updateUser(jsonForm);
            };
            addDiscount = function (){
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addDiscount").serializeObject();
                jsonForm.upper_limit = jsonForm.upper_limit == "" ? 0 : jsonForm.upper_limit;
                scope.details.discount.addDiscount(jsonForm,scope.details.discount.selected_discount );
            };
            updateDiscount = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateDiscount").serializeObject();
                scope.details.discount.updateDiscount(jsonForm,scope.details.discount.selected_discount);
            };
            addCustomer = function (form){
                $rootScope.settings.modal.adding = true
                if(form == '.addCustomersForm'){
                    jsonForm = $(form).serializeObject();
                    scope.customers.addCustomer(jsonForm);
                }
            };
            updateCustomer = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateCustomersForm").serializeObject();
                scope.customers.updateCustomer(jsonForm);
            };
            debtpaydata = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".debtpayForm").serializeObject();
                console.log(jsonForm, parseInt(jsonForm.amount_paid));
                if(parseInt(jsonForm.amount_paid) < 1 || jsonForm.amount_paid == ''){
                    $rootScope.settings.modal.msgprompt(['ERROR', 'FILL AMOUNT PAID WITH A VALUE']);
                    //console.log($rootScope.settings.modal.msg);
                    $rootScope.$apply();
                    return;
                }
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
                $(".report").fadeIn(100, function () {
                    $(".report").delay(1500).fadeOut(100, function(){
                        $(".modal .close").trigger("click");
                        $rootScope.settings.modal.msg = "";
                        $(".modal input").val("");
                    });
                });
            }
            $rootScope.settings.modal.fademsg = function(){
                console.log('dvs');
                $(".report").fadeIn(50, function(){
                    $('.report').delay(3500).fadeOut(10);
                });
            };
            $('.modal').on('hidden.bs.modal', function(){
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
            });
            $('.modal .close').on('click', function(){
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
            });

        }
    };
}]);
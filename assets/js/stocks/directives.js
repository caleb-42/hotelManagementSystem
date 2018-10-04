app.directive('productlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        template: '<div class = "listcont"><div  class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in productstock.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (productstock.jslist.newItemArray = (productstock.jslist.values | filter:{\'item\' : searchbox.imp}:strict))" ng-click = "productstock.jslist.select($index, items.id); details.discount.jslist.createList()" ng-class = "{\'actparent\' :productstock.jslist.selected == items.id}"><span class = "itemname col-2">{{items.item}}</span><span class = "text-center stkleft col-1">{{items.current_stock}}</span><span class = "text-center itemcost col-1">{{items.current_price}}</span><span class = "text-center description col-2">{{items.description}}</span><span class = "text-center category col-2">{{items.category}}</span><span class = "text-center type col-2">{{items.type}}</span><span class = "text-center shelfitem col-2">{{items.shelf_item}}</span></li></ul></div></div>',

        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.productstock.jslist = {
                createList: function () {
                    listdetails = scope.productstock.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.productstock.jslist.values = result;
                        scope.productstock.jslist.selected = null;
                    });
                    scope.productstock.listhddata = [
                        {
                            name: "Name",
                            width: "col-2",
                        },
                        {
                            name: "Stock",
                            width: "col-1",
                        },
                        {
                            name: "Price",
                            width: "col-1",
                        },
                        {
                            name: "Description",
                            width: "col-2",
                        },
                        {
                            name: "Category",
                            width: "col-2",
                        },
                        {
                            name: "Type",
                            width: "col-2",
                        },
                        {
                            name: "Shelf Item",
                            width: "col-2",
                        },
                    ];
                    /* if(scope.productstock.jslist.selected){
                        scope.productstock.jslist.selectedObj = $filter('filter')(scope.productstock.jslist.values, {id : scope.productstock.jslist.selected}, true);
                        
                        console.log(scope.productstock.jslist.selectedObj);
                    } */
                },
                select: function (index, id) {
                    scope.productstock.jslist.selected = id;
                    scope.productstock.jslist.selectedObj = scope.productstock.jslist.newItemArray[index];
                    scope.details.discount.selected_discount = 'item';
                    console.log(scope.productstock.jslist.selectedObj);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.productstock.jslist.createList();
        }
    };
}]);

app.directive('discountlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        template: `
        <div ng-switch on = "details.discount.selected_discount" class = "w-100 h-70 ovflo-y mb-2 discountlist">

                    <div ng-switch-when = "item" class = "w-100 ">
                    
                    <ul ng-if = "productstock.jslist.selectedObj">
                        <li class = "row w-100 b-1 py-4 px-3" ng-class = "{\'btn-lytgrn\': details.discount.jslist.selected == discnt.id}" ng-repeat="discnt in details.discount.jslist.values">
                            <div class = "col-4"><div class = "center text-center btn-info" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md';details.discount.jslist.select($index, discnt.id); " data-toggle="modal" data-target="#crud"><h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4></div></div>
                            <div class = "col-8 text-right dark pr-4 "><div ng-click = "details.discount.jslist.select($index, discnt.id);"><h5 class = "font-weight-bold">{{discnt.discount_name}}</h5><p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p></div></div>
                        </li>
                    </ul>
                    <h4 class = "center w-100 opac-50" ng-if = "!productstock.jslist.selectedObj"> Select an item</h4>
                    </div>
                    <div ng-switch-when = "total">
                    <ul>
                        <li class = "row w-100 b-1 py-4 px-3" ng-class = "{\'btn-lytgrn\': details.discount.jslist.selected == discnt.id}" ng-repeat="discnt in details.discount.jslist.values" >
                            <div class = "col-4"><div class = "center text-center btn-info"  ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md';details.discount.jslist.select($index, discnt.id); " data-toggle="modal" data-target="#crud"><h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4></div></div>
                            <div class = "col-8 text-right dark pr-4 "><div ng-click = "details.discount.jslist.select($index, discnt.id);"><h5 class = "font-weight-bold">{{discnt.discount_name}}</h5><p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p></div></div>
                        </li>
                    </ul>
                    </div>
                
                </div>
        `,
        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.details.discount.jslist = {
                createList: function () {
                    listdetails = scope.details.discount.itemlist(scope.details.discount.selected_discount);

                    jsonlist = listdetails.jsonfunc;

                    resultfiltered = [];

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        result.forEach(function (element) {
                            if (scope.details.discount.selected_discount == "total" && element.discount_item == "all") {
                                resultfiltered.push(element);
                                console.log(element);
                            } else if (scope.details.discount.selected_discount == "item" && scope.productstock.jslist.selectedObj) {
                                if (element.discount_item == scope.productstock.jslist.selectedObj.item) {
                                    resultfiltered.push(element)
                                    console.log(element);
                                }
                            }else{
                                return 0;
                            }
                        });
                        scope.details.discount.jslist.values = resultfiltered;
                        scope.details.discount.jslist.selected = null;
                    });
                },
                select: function (index, id) {
                    scope.details.discount.jslist.selected = id;
                    scope.details.discount.jslist.selectedObj = scope.details.discount.jslist.values[index];
                    console.log(scope.details.discount.jslist.selectedObj);
                },
                toggleOut: function () {
                    $(".discntfade").fadeOut(200);
                },
                toggleIn: function () {
                    $(".discntfade").delay(500).fadeIn(200);
                }
            }
            scope.details.discount.jslist.createList();
        }
    };
}]);


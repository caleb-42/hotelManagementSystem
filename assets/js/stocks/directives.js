app.directive('productlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        template: '<div class = "listcont"><div  class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in stocks.listhddata">{{hd.name}}</span></div><div class = "h-80 listbody ovflo-y pb-4" ><ul class = "list" ><li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (stocks.jslist.newItemArray = (stocks.jslist.values | filter:{\'item\' : searchbox.imp}:strict))" ng-click = "stocks.jslist.select($index, items.id)" ng-class = "{\'actparent\' :stocks.jslist.selected == items.id}"><span class = "itemname col-2">{{items.item}}</span><span class = "text-center stkleft col-1">{{items.current_stock}}</span><span class = "text-center itemcost col-1">{{items.current_price}}</span><span class = "text-center description col-2">{{items.description}}</span><span class = "text-center category col-2">{{items.category}}</span><span class = "text-center type col-2">{{items.type}}</span><span class = "text-center shelfitem col-2">{{items.shelf_item}}</span></li></ul></div></div>',

        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.stocks.jslist = {
                createList: function () {
                    listdetails = scope.stocks.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.stocks.jslist.values = result;
                        scope.stocks.jslist.selected = null;
                    });
                    scope.stocks.listhddata = [
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
                    /* if(scope.stocks.jslist.selected){
                        scope.stocks.jslist.selectedObj = $filter('filter')(scope.stocks.jslist.values, {id : scope.stocks.jslist.selected}, true);
                        
                        console.log(scope.stocks.jslist.selectedObj);
                    } */
                },
                select: function (index, id) {
                    scope.stocks.jslist.selected = id;
                    scope.stocks.jslist.selectedObj = scope.stocks.jslist.newItemArray[index];
                    console.log(scope.stocks.jslist.selectedObj);
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.stocks.jslist.createList();
        }
    };
}]);

app.directive('discountlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        template: `
        <div ng-switch on = "details.discount.selected_discount" class = "w-100 h-70 ovflo-y px-3 mb-2 discountlist">

                    <div ng-switch-when = "item" class = "w-100">
                    
                    <ul>
                        <!--<li class = "row w-100 b-1 py-4" ng-repeat="discnt in details.discount.jslist.values"  ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud">
                            <div class = "col-4"><div class = "center text-center btn-info"><h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4></div></div>
                            <div class = "col-8 text-right dark pr-4 "><div><h5 class = "font-weight-bold">{{discnt.discount_name}}</h5><p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p></div></div>
                        </li>-->
                    </ul>
                    </div>
                    <div ng-switch-when = "total">
                    <ul>
                        <li class = "row w-100 b-1 py-4" ng-repeat="discnt in details.discount.jslist.values"  ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud">
                            <div class = "col-4"><div class = "center text-center btn-info"><h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4></div></div>
                            <div class = "col-8 text-right dark pr-4 "><div><h5 class = "font-weight-bold">{{discnt.discount_name}}</h5><p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p></div></div>
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
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.details.discount.jslist.values = result;
                        scope.details.discount.jslist.selected = null;
                    });
                },
                select: function (index, id) {
                    scope.details.discount.jslist.selected = id;
                    scope.details.discount.jslist.selectedObj = scope.details.discount.jslist.newItemArray[index];
                    console.log(scope.details.discount.jslist.selectedObj);
                },
                toggleOut : function(){
                    $(".discountlist").fadeOut(200);
                },
                toggleIn : function(){
                    $(".discountlist").delay(500).fadeIn(200);
                }
            }
            scope.details.discount.jslist.createList();
        }
    };
}]);


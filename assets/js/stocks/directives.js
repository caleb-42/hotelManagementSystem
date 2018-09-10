app.directive('productlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div  class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in stocks.listhddata">{{hd.name}}</span></div><div class = "h-100 listbody ovflo-y " ><ul class = "list" ><li class = "itemlistrow row align-items-center f-12" ng-repeat = "items in (stocks.jslist.newItemArray = (stocks.jslist.values | filter:searchbox.imp))" ng-click = "stocks.jslist.select($index, items.id)" ng-class = "{\'actparent\' :stocks.jslist.selected == items.id}"><span class = "itemname col-2">{{items.item}}</span><span class = "text-center stkleft col-1">{{items.current_stock}}</span><span class = "text-center itemcost col-1">{{items.current_price}}</span><span class = "text-center description col-2">{{items.description}}</span><span class = "text-center category col-2">{{items.category}}</span><span class = "text-center type col-2">{{items.type}}</span><span class = "text-center shelfitem col-2">{{items.shelf_item}}</span></li></ul></div>',

        scope: false,

        link: function (scope, element, attrs) {
            scope.stocks.jslist = {
                createList: function () {
                    listdetails = scope.stocks.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.stocks.jslist.values = result;
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
                            name: "Shelf  Item",
                            width: "col-2",
                        },
                    ];
                },
                select: function (index, id) {
                    scope.stocks.jslist.selected = id;
                    scope.stocks.jslist.selectedObj = scope.stocks.jslist.newItemArray[index];
                    console.log(scope.stocks.jslist.newItemArray[index]);
                }
            }
            scope.stocks.jslist.createList();
        }
    };
}]);


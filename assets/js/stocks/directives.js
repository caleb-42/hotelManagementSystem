app.directive('productlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/stocks/listTemplates.php?list=stock',

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
                },
                shelfitem : 'yes'
            }
            scope.productstock.jslist.createList();
        }
    };
}]);

app.directive('discountlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/stocks/listTemplates.php?list=discount',
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


app.directive('productlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: '<div  class = "listhd pr-3 row"><span class="{{hd.width}}"  ng-class =\'{"text-center" : !$first}\' ng-repeat = "hd in products.listhddata">{{hd.name}}</span></div><div class = "h-100 listbody ovflo-y " ><ul class = "list" ><li class = "itemlistrow row align-items-center f-12" ng-repeat = "items in (products.jslist.newItemArray = (products.jslist.values | filter:searchbox.imp))" ng-click = "products.jslist.select($index, items.id)" ng-class = "{\'actparent\' :products.jslist.selected == items.id}"><span class = "itemname col-2">{{items.item}}</span><span class = "text-center stkleft col-1">{{items.current_stock}}</span><span class = "text-center itemcost col-1">{{items.current_price}}</span><span class = "text-center description col-2">{{items.description}}</span><span class = "text-center category col-2">{{items.category}}</span><span class = "text-center type col-2">{{items.type}}</span><span class = "text-center shelfitem col-2">{{items.shelf_item}}</span></li></ul></div>',

        /* */
        scope: false,

        link: function (scope, element, attrs) {
            scope.products.jslist = {
                createList: function () {
                    listdetails = scope.products.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.products.jslist.values = result;
                    });
                    scope.products.listhddata = [
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
                        /*{
                            name: "Discount Available",
                            width: "col-3",
                        },
                        {
                            name: "Discount Criteria",
                            width: "col-3",
                        },
                        {
                            name: "Discount Rate",
                            width: "col-3",
                        }*/
                    ];
                },
                select: function (index, id) {
                    scope.products.jslist.selected = id;

                    console.log(scope.products.jslist.newItemArray[index]);
                }
            }
            scope.products.jslist.createList();
        }
    };
}]);

/*app.directive('prodthumb', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        template: `<div class="details row justify-content-center">
<div class=" text-center mt-4">
<h5 class="mb-3">Product Photo</h5>
<div class="productpic"></div>
</div>
<div><input  ng-change = "product.getpic" type="file" name="upload-img" id="upload-img" value = "Upload Photo" /><button  ng-if = "product.uploaded" class=" btn btn-danger" ng-change = "product.getpic">Upload Photo</button></div>
</div>`,

         
        scope: false,

        link: function (scope, element, attrs) {
            scope.product = {
                picObj: null,
                uploaded: false,
                initialize: function () {
                    scope.product.picObj = $('.productpic').croppie({
                        viewport: {
                            width: 200,
                            height: 200,
                            type: 'square'
                        },
                        boundary: {
                            width: 100,
                            height: 100
                        }

                    });
                    scope.product.picObj.croppie('bind', {
                        url: '/assets/img/4.png'
                    });
                },
                getpic: function () {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        scope.product.picObj.croppie("bind", {
                            url: event.target.result
                        }).then(function () {
                            console.log(event.target.result);
                        })
                    }
                    reader.readAsDataURL(this.files[0]);
                    scope.product.uploaded = true
                },
                cropImg: function () {
                    scope.product.picObj.croppie('result', {
                        type: 'canvas',
                        size: 'viewport',
                        format: 'png'
                    }).then(function (response) {
                        $.ajax({
                            url: "./uploadImg.php",
                            method: "POST",
                            data: {
                                "image": response
                            },
                            success: function (data) {
                                $('.productpic').html(data);
                            }
                        });
                        console.log(response);
                    });
                }
            }
            scope.product.initialize();
        }
    };
}]);*/

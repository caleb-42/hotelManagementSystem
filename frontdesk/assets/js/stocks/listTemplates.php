<div ng-if = "<?php echo $_GET['list']   == 'stock'?>" class = "listcont">
    <div  class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in productstock.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (productstock.jslist.newItemArray = (productstock.jslist.values | filter:{'item' : searchbox.imp}:strict))" ng-click = "productstock.jslist.select($index, items.id); details.discount.jslist.createList()" ng-class = "{'actparent' :productstock.jslist.selected == items.id}">
                <span class = "itemname col-2">{{items.item}}</span>
                <span class = "text-center stkleft col-1">{{items.current_stock}}</span>
                <span class = "text-center itemcost col-1">{{items.current_price}}</span>
                <span class = "text-center description col-2">{{items.description}}</span>
                <span class = "text-center category col-2">{{items.category}}</span>
                <span class = "text-center type col-2">{{items.type}}</span>
                <span class = "text-center shelfitem col-2">{{items.shelf_item}}</span>
            </li>
        </ul>
    </div>
</div>

<div  ng-if = "<?php echo $_GET['list'] == 'discount'?>"  ng-switch on = "details.discount.selected_discount" class = "w-100 h-70 ovflo-y mb-2 discountlist">

    <div ng-switch-when = "item" class = "w-100 ">

        <ul ng-if = "productstock.jslist.selectedObj">
            <li class = "row w-100 b-1 py-4 px-3" ng-class = "{'btn-lytgrn': details.discount.jslist.selected == discnt.id}" ng-repeat="discnt in details.discount.jslist.values">
                <div class = "col-4"><div class = "center text-center btn-info" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md';details.discount.jslist.select($index, discnt.id); " data-toggle="modal" data-target="#crud"><h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4></div></div>
                <div class = "col-8 text-right dark pr-4 "><div ng-click = "details.discount.jslist.select($index, discnt.id);"><h5 class = "font-weight-bold">{{discnt.discount_name}}</h5><p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p></div></div>
            </li>
        </ul>
        <h4 class = "center w-100 opac-50" ng-if = "!productstock.jslist.selectedObj"> Select an item</h4>
    </div>
    <div ng-switch-when = "total">
        <ul>
            <li class = "row w-100 b-1 py-4 px-3" ng-class = "{'btn-lytgrn': details.discount.jslist.selected == discnt.id}" ng-repeat="discnt in details.discount.jslist.values" >
                <div class = "col-4">
                    <div class = "center text-center btn-info"  ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md';details.discount.jslist.select($index, discnt.id); " data-toggle="modal" data-target="#crud">
                        <h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4>
                    </div>
                </div>
                <div class = "col-8 text-right dark pr-4 ">
                    <div ng-click = "details.discount.jslist.select($index, discnt.id);">
                        <h5 class = "font-weight-bold">{{discnt.discount_name}}</h5>
                        <p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

</div>
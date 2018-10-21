
<!-- ............jslist start ..............-->
<div ng-if = "<?php echo $_GET['type']   == 'jslist'?>" class="animate-switch-container h-100 pb-4 listcont" ng-switch on="layout">
    <div class="animate-switch h-100" ng-switch-default>
        <div class = "itemboxhd ovflo-y h-100 w-100">
            <div class = "itembox " ng-repeat = "items in (jslist.newItemArray = (jslist.values | filter:searchquery))" ng-click = "jslist.addToCart($index)">
                <h5>{{items.item}}</h5>
            </div>
        </div>
    </div>
    <div class="animate-switch layout  pb-5 h-100"  ng-switch-when="listlayout">
        <div  class = "listhd pr-3 row">
            <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listhddata">{{hd.name}}</span>
        </div>
        <div class = "h-100 listbody ovflo-y " >
            <ul class = "list" >
                <li class = "itemlistrow row" ng-repeat = "items in (jslist.newItemArray = (jslist.values | filter:searchquery))" ng-click = "jslist.addToCart($index)">
                    <span class = "itemname col-6">{{items.item}}</span>
                    <span class = "text-center stkleft col-3">{{items.current_stock}}</span>
                    <span class = "text-center itemcost col-3">{{items.current_price}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- ............jslist start ..............-->


<!-- ............cartitems start ..............-->
<div ng-if = "<?php echo $_GET['type']   == 'cartitems'?>" ng-repeat = "cartItem in cart" class="cartItem-row row align-items-center pt-4">
    <div class = "hvr-overlay anim">
        <div class = "w-40 float-right row h-100 align-items-center">
            <i class = " col-4 fa-2x fa fa-plus blac anim" ng-click = "cartitemsOps.addItemQty($index, cartItem.current_stock, cartItem.editqty)"></i>
            <i class = " col-4 fa-2x blac fa fa-minus anim" ng-click = "cartitemsOps.minusItemQty($index, cartItem.current_stock, cartItem.editqty)"></i>
            <i class = "col-4 blac fa-2x fa fa-times anim" ng-click = "cartitemsOps.removeFromCart($index)"></i>
        </div>
    </div>
    <div class="col-3 m-0  align-items-start" style = "margin-bottom:20px !important;">
        <div class="cartItem-img">
            <button class="cartItem-num anim" ng-class = "{'cartItem-numAlign' : cartItem.editqty}" ng-style = "{'background' : cartitemsOps.aboveStock(cartItem.quantity, cartItem.current_stock, cartItem.editqty,cartItem.shelf_item) ? 'red' : '#49B756'}" ng-click = "cartItem.editqty =  true; cartitemsOps.activateBlinkCursor($event);">
                <p ng-class = "{'gone' : cartItem.editqty}">{{cartItem.quantity}}</p>
                <input  maxlength = "6" ng-blur = "cartItem.editqty =  false; cartitemsOps.deactivateBlinkCursor($event, $index,cartItem.quantity, cartItem.current_stock); totalcost()"  ng-class = "{'vanish' : !cartItem.editqty}" ng-model = "cartItem.quantity" ng-change = "cartitemsOps.calc($index, cartItem.current_stock); "/>
            </button>
        </div>
    </div>
    <div class="col-9 m-0 row px-1 h-100 pt-2 align-items-center nav-tabs pb-4">
        <div class="col-7 row px-0 h-100 align-items-center">
            <div>
                <h6 class="m-0 font-fam-Montserrat w-100 excerpt font-weight-bold opac-70">{{cartItem.item}}</h6>
                <p class="m-0 font-fam-Myriad opac-50 f-13 excerpt">{{cartItem.description}}</p>
            </div>
        </div>
        <div class="h-100 col-5 row  justify-content-center align-items-center">
            <h6 class="itemCost h-100 m-0 w-100 text-center font-fam-Montserrat opac-50 {{discount == 'Item' ? ' f-13 pb-2' : null}}">{{cartItem.net_cost}}</h6>
            <h6 class="itemCost  m-0 text-center font-fam-Montserrat-bold f-16 choral {{discount == 'Item' ? null : 'gone'}}">{{cartItem.discounted_net_cost}}</h6>
        </div>
    </div>
</div>
<!-- ............cartitems end ..............-->


<!-- ............ordersgrid start ..............-->
<div ng-if = "<?php echo $_GET['type']   == 'ordersgrid'?>" class = "orderRow h-100" >
    <div ng-click = "order.focus(gridorders.buyer.full_name, $index)" class = "anim pdiv pointer" ng-repeat = "gridorders in order.list">
        <div class = '  anim row justify-content-center align-items-center'  ng-class = "{'divfocus' : order.focused  == gridorders.buyer.full_name, 'adiv' : order.focused  != gridorders.buyer.full_name}">
            <h6>{{gridorders.buyer.full_name}}</h6>
        </div>
    </div>
</div>
<!-- ............ordersgrid end ..............-->
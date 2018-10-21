
<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'sales'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in salesHistory.listhddata ">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (salesHistory.jslist.newItemArray = (salesHistory.jslist.values | filter:searchbox.imp))" ng-click = "salesHistory.jslist.select($index, hist.txn_ref)" ng-class = "{'actparent' : salesHistory.jslist.selected == hist.txn_ref}">
                <span class = "custref col-1">{{hist.txn_ref}}</span>
                <span class = "text-center paymeth col-2">{{hist.pay_method}}</span>
                <span class = "text-center items col-1">{{hist.total_items}}</span>
                <span class = "text-center cost col-1">{{hist.total_cost}}</span>
                <span class = "text-center discost col-1">{{hist.discounted_total_cost}}</span>
                <span class = "text-center discnt col-1">{{hist.transaction_discount}}</span>
                <span class = "text-center deposit col-2">{{hist.deposited}}</span>
                <span class = "text-center bal col-1">{{hist.balance}}</span>
                <span class = "text-center status col-2">{{hist.payment_status}}</span>
            </li>
        </ul>
    </div>
</div>



<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'stocks'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in stockHistory.listhddata">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (stockHistory.jslist.newItemArray = (stockHistory.jslist.values | filter:searchbox.imp))">
                <span class = "text-left tranxref col-2">{{hist.txn_ref}}</span>
                <span class = "text-center item col-1">{{hist.item}}</span>
                <span class = "text-center prevstk col-2">{{hist.prev_stock}}</span>
                <span class = "text-center qty col-1">{{hist.quantity}}</span>
                <span class = "text-center newstk col-2">{{hist.new_stock}}</span>
                <span class = "text-center cat col-2">{{hist.category}}</span>
                <span class = "text-center tranxdate col-2">{{hist.txn_date}}</span>
            </li>
        </ul>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'customers'?>">
    <div class = "listcont hs-100">
            <div class = "listhd pr-3 row">
                <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in customers.listhddata">{{hd.name}}</span>
            </div>
            <div class = "hs-70 listbody ovflo-y pb-4" ><ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (customers.jslist.newItemArray = (customers.jslist.values | filter:searchbox.imp))" ng-click = "customers.jslist.select($index, hist.customer_id);" ng-class = "{'actparent' : customers.jslist.selected == hist.customer_id}">
                    <span class = "text-left custid {{customers.listhddata[0].width}}">{{hist.customer_id}}</span>
                    <span class = "text-center fname {{customers.listhddata[1].width}}">{{hist.full_name}}</span>
                    <span class = "text-center phone {{customers.listhddata[2].width}}">{{hist.phone_number}}</span>
                    <span class = "text-center address {{customers.listhddata[3].width}}">{{hist.contact_address}}</span>
                    <span class = "text-center gender {{customers.listhddata[4].width}}">{{hist.gender}}</span>
                    <span class = "text-center outbal {{customers.listhddata[5].width}}">{{hist.outstanding_balance}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'tranxsales'?>">
    <div class = "row hs-80 {{listsales.jslist.active ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select A Transaction</h4>
    </div>
    <div class = "listcont {{!listsales.jslist.active ? 'gone' : 'notgone'}}">
        <div class = "orange font-fam-Montserrat-bold row p-2 justify-content-between w-100" style = "border-radius: 5px; margin : 10px 0 !important;">
            <span>Sales Rep</span>
            <span>{{listsales.jslist.tranx.sales_rep}}</span>
        </div>
        <div class = "orange font-fam-Montserrat-bold row p-2 justify-content-between w-100" style = "border-radius: 5px; margin : 10px 0 !important;">
            <span>Tranx Time</span>
            <span>{{listsales.jslist.tranx.txn_time}}</span>
        </div>
        <div class = "orange font-fam-Montserrat-bold row p-2 justify-content-between w-100" style = "border-radius: 5px; margin : 10px 0 20px !important;">
            <span>Customer Ref</span>
            <span>{{listsales.jslist.tranx.customer_ref}}</span>
        </div>
        <div class = "listhd pr-3 row">
            <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listsales.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-40 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "sales in listsales.jslist.values">
                    <span class = "item col-3">{{sales.item}}</span>
                    <span class = "text-center login col-1">{{sales.quantity}}</span>
                    <span class = "text-center login col-2">{{sales.unit_cost}}</span>
                    <span class = "text-center login col-2">{{sales.net_cost}}</span>
                    <span class = "text-center login col-2">{{sales.discount_amount}}</span>
                    <span class = "text-center logoff col-1">{{sales.discount_rate}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'tranxlist'?>">
    <div class = "row hs-80 {{listtranxs.jslist.active ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select A Customer</h4>
    </div>
    <div class = "listcont {{!listtranxs.jslist.active ? 'gone' : 'notgone'}}">
        <div class = " row justify-content-between w-100" style = 'margin:20px 0 !important;'>
            <button ng-disabled = "!listtranxs.jslist.selected" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Customers'; settings.modal.name = 'Debt Clear'; settings.modal.size = 'md'; " class="btn btn-block btn-danger font-fam-Montserrat-bold"> Clear Debt </button>
        </div>
        <div class = "listhd pr-3 row">
            <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listtranxs.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-50 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "sales in listtranxs.jslist.values" ng-click = "listtranxs.jslist.select($index, sales.txn_ref);" ng-class = "{'actparent' : listtranxs.jslist.selected == sales.txn_ref}">
                <span class = "tranxref col-2">{{sales.txn_ref}}</span>
                <span class = "text-center cost col-4">{{sales.total_cost}}</span>
                <span class = "text-center deposit col-4">{{sales.deposited}}</span>
                <span class = "text-center bal col-2">{{sales.balance}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
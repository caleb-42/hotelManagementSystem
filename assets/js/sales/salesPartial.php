<div class="prime-hd anim" ng-controller="primehd">
    <div class="statusbar grn row  align-items-end pl-1">
        <div class="tabnav col-7 row">
            <button ng-repeat='nav in tabnav.navs' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected}">
                <h5>{{nav.name}}</h5>
            </button>
        </div>
        <!--tabnav end-->
        <div class="searchbox col-5 h-100 row  align-items-end pb-1" ng-mouseleave="searchbox.iconhover = true">
            <div class="col-10">
                <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
            <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
            <div class="fa fa-search fa-2x row  align-items-end pb-1 wht col-2" ng-mouseover="searchbox.iconhover = false"></div>
        </div>

    </div>
    <!--statusbar for primehd end-->

    <div class="prime-body">
        <div class="animate-switch-container" ng-switch on="tabnav.selected">
            <div class="animate-switch Sales h-100" ng-switch-default>
                <div class="products  anim " ng-class='{"h-100": !sales.order.panel, "h-70": sales.order.panel}'>
                    <div class="p-3 px-4 itemlayout w-100" ng-class='{" h-95": !sales.order.panel, " h-93": sales.order.panel}'>
                        <div class="row justify-content-between">
                            <h4 class="mb-4 pb-1 mt-3 font-fam-Montserrat-bold">Products</h4>
                            <div class="row align-items-center opac-50"><span class="mr-4" ng-click="sales.products.layout = 'listlayout' "><img width = "28px" height = "20px" src = "assets/img/layouticons-06.png"/></span><span ng-click="sales.products.layout = 'gridlayout' "><img width = "20px" height = "20px" src = "assets/img/layouticons-07.png"/></span></div>
                        </div>
                        <div class="mb-5 item-container">
                            <jslist class="font-fam-Montserrat" layout="sales.products.layout" searchquery="searchbox.imp" getlistfunc="sales.products.itemlist()"></jslist>
                        </div>
                    </div>
                    <div class="orderbtn w-100"><button class="ml-2 h-100 btn-danger px-5 " ng-class="{'hvr-pulse-grow' : sales.order.orderExist}" ng-click="sales.order.togglepanel()">Orders</button></div>
                </div>
                <div class="orders anim px-4" ng-class='{"h-0": !sales.order.panel, "h-30": sales.order.panel}'>

                    <!--<ordersgrid list = "surcharge.order.list"></ordersgrid>-->
                    <ordersgrid ordercheck="sales.order.checkOrderExist()"></ordersgrid>

                </div>
            </div>
            <div class="animate-switch" ng-switch-when="History">HomeSpan</div>
        </div>
    </div>
</div>
<!--primehd end-->

<div class="main-sidebar-right hs-100 anim" ng-controller="rightsidebar">
    <div class="statusbar grn row align-items-end justify-content-center">
        <h4 class="text-center wht">Cart <i class="fa fa-shopping-cart"></i></h4>
    </div>
    <!--statusbar for main-sidebar-right end -->
    <div class="sidebar-body" ng-switch on="tabnav.selected">
        <div ng-switch-default>
            <div class="buyer-status row  align-items-center pointer anim" ng-class="{'ordercart' : !surcharge.order.orderSelect}">
                <div class="col-3 m-0" ng-click="buyer.customer.selected = buyer.customer.selectedDefault">
                    <div class="{{buyer.customer.selected.sex == 'male' ? 'avatar-img' : 'avatar-img-female'}}"></div>
                </div>
                <div class="col-6 row  justify-content-start px-1 h-100  align-items-center" ng-click="buyer.showPanel = 'search'; settings.modal.active = 'customer'; settings.modal.name = 'Select Customer'; settings.modal.size = 'lg' " data-toggle="modal" data-target="#Customer">
                    <span class="m-0 p-0 buyerbio"><p class="m-0 f-17 font-fam-Montserrat pointer excerpt" style = "width:150px;">{{buyer.customer.selected.name == buyer.customer.selectedDefault.name ? 'Select Customer' : buyer.customer.selected.name}}</p><p class="f-13-5 m-0 font-fam-Montserrat opac-50 pointer" ng-class = "{'gone' : buyer.customer.selected.name == buyer.customer.selectedDefault.name}">{{buyer.customer.selected.type}} | {{buyer.customer.selected.bal}}</p></span>
                </div>
                <div class="col-3" ng-click="buyer.showPanel = 'addnew'; settings.modal.active = 'customer'; settings.modal.name = 'Add Customer'; settings.modal.size = 'lg' " data-toggle="modal" data-target="#Customer" ng-class="{'btn-danger py-1' : !surcharge.order.orderSelect}" ng-style="{'box-shadow' : !surcharge.order.orderSelect ? '-3px 3px  5px #444' : 'none'}">
                    <i class="fa addicon pointer " ng-if="surcharge.order.orderSelect"></i>
                    <h4 class="wht f-13 mt-1" ng-if="!surcharge.order.orderSelect">ORDER</h4>
                </div>
            </div>
            <div class="cart pb-4 anim">
                <cartitems cart="cart.cartlist" totalcost="surcharge.CalcCosts()" discount = "surcharge.discount.type"></cartitems>
            </div>
            <div class="surcharge p-3 anim">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <input type="radio" name="radio" value="Item" id="itemdis" ng-model='surcharge.discount.type' />
                        <label for="itemdis" class="f-13">Item Discount</label>
                    </div>
                    <div class="col-6">
                        <input type="radio" name="radio" value="Total" id="totaldis" ng-model='surcharge.discount.type' />
                        <label for="totaldis" class="f-13"> Total Discount</label>
                    </div>
                </div>
                <!--<button class="btn-block btn "><span class="mr-1">N</span>{{cart.TotalItemCost}}</button>-->
                <button class="btn-block btn btn-warning my-2"><span class="mr-1 mt-1">N</span>{{surcharge.TotalItemCost}}</button>
                <div class="row">
                    <button class="col-5 btn sechue" ng-click="surcharge.order.command()">{{!surcharge.order.orderSelect ? 'Delete Order' : 'Open Order'}}</button>
                    <button class="offset-2 col-5 btn btn-success" data-toggle="modal" data-target="#Customer" ng-click="settings.modal.active = 'payment'; surcharge.payment.preview(); settings.modal.name = 'Reciept Preview'; settings.modal.size = 'md' ">Pay</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="Customer" role="dialog" modalentry></div>

</div>
<!--main-sidebar-right end-->
<div class="clr"></div>

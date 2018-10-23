<div ng-controller="sales">
<div class="prime-hd anim  {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
    <div class="statusbar blu row  align-items-end pl-1">
        <div class="tabnav col-12 row">
            <button ng-repeat='nav in tabnav.navs | objtoarray' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}">
                <h5>{{nav.name}}</h5>
            </button>
        </div>
        <!--tabnav end-->
        

    </div>
    <!--statusbar for primehd end-->

    <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'p-0'}}">
        <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
            <div class="animate-switch Sales h-100" ng-switch-default>
                <div class="products  anim " ng-class='{"h-100": !sales.order.panel, "h-70": sales.order.panel}'>
                    <div class="p-3 px-4 itemlayout w-100" ng-class='{" h-95": !sales.order.panel, " h-93": sales.order.panel}'>
                        <div class="mb-5 item-container">
                            <div class="userlisthd row justify-content-between">
                                <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                                <div class="my-4">
                                    <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Guest'; settings.modal.name = 'Add Guest'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button>
                                    <button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Guest'; settings.modal.name = 'Update Guest'; settings.modal.size = 'lg'; " ng-disabled="!guest.jslist.selected">Update</button>
                                    <!-- <button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button> -->
                                </div>
                            </div>
                            <jslist class="font-fam-Montserrat" layout="sales.products.layout" searchquery="searchbox.imp" getlistfunc="sales.products.itemlist()"></jslist>
                        </div>
                    </div>
                    <div class="orderbtn w-100"><button class="ml-2 h-100 btn-danger px-5 " ng-class="{'hvr-pulse-grow' : sales.order.orderExist}" ng-click="sales.order.togglepanel()">Orders</button></div>
                </div>
                <div class="orders anim px-4" ng-class='{"h-0": !sales.order.panel, "h-30": sales.order.panel}'>

                    <!--<ordersgrid list = "sales.order.list"></ordersgrid>-->
                    <ordersgrid ordercheck="sales.order.checkOrderExist()"></ordersgrid>

                </div>
            </div>
            <div class="animate-switch" ng-switch-when="History">HomeSpan</div>
        </div>
    </div>
</div>
<!--primehd end-->

<div class="main-sidebar-right hs-100 anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 vanish'}}">
    <div class="statusbar blu row align-items-end justify-content-center">
            <div class="searchbox col-12 h-100 row  align-items-end pb-1">
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" />
                </div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" href = "../php1/restaurant_bar/restaurant_logoff.php" ng-mouseenter="settings.log = false;" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm btn-outline-secondary wht mb-2">{{settings.log ? settings.user : 'log out'}}</a>
            </div>
        </div>
    </div>
    <!--statusbar for main-sidebar-right end -->
    <div class="sidebar-body" ng-switch on="tabnav.selected">
        <div ng-switch-default class = " whtback hs-100 anim">
            <!--<ordersgrid list = "sales.order.list"></ordersgrid>-->
            <accordion></accordion>
        </div>
    </div>


    <div class="modal fade" id="crud" role="dialog" modalentry></div>

</div>
<!--main-sidebar-right end-->
<div class="clr"></div>
</div>
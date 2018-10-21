<div ng-controller="records"> <!-- {{tabnav.selected == 'Customers' ? null : 'w-100'}} -->
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar grn row  align-items-end pl-1">
            <div class="tabnav col-7 row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox col-5 h-100 row  align-items-end pb-1">
            <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/restaurant_bar/restaurant_logoff.php" class = "anim btn w-100 pointer font-fam-Montserrat-bold btn-sm btn-outline-secondary wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? null : 'px-0'}}">
            <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch SalesHistory px-4 h-100" ng-switch-default>
                    <div class="prodlisthd row justify-content-center">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold text-center">Sales History</h4>
                    </div>
                    <div class="saleshistorylist h-80 " ng-controller="saleshistory">
                        <saleshistorylist></saleshistorylist>
                    </div>
                </div>
                <div class="animate-switch StockHistory px-4 h-100" ng-switch-when="Stocks">
                    <div class="prodlisthd row justify-content-center">
                    <h4 class=" my-4 py-2 font-fam-Montserrat-bold text-center">Stock History</h4>
                    </div>
                    <div class="stockhistorylist h-80" ng-controller="stockhistory">
                         <stockhistorylist></stockhistorylist> 
                    </div>
                </div>
                <div class="animate-switch Customers px-4 h-100" ng-switch-when="Customers">
                    <div class="customerslist h-80" ng-controller="customers">
                        <div class="prodlisthd row justify-content-between">
                            <h4 class=" my-4 py-2 font-fam-Montserrat-bold text-center">Customers</h4>
                            
                            <div class="my-4">
                                <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Customers'; settings.modal.name = 'Add Customer'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button>
                                <button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Customers'; settings.modal.name = 'Update Customer'; settings.modal.size = 'lg'; " ng-disabled="!customers.jslist.selected || (customers.jslist.selected | limitTo:3) == 'LOD'">Update</button>
                                <button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="customers.deleteCustomer()"  ng-disabled="!customers.jslist.selected || (customers.jslist.selected | limitTo:3) == 'LOD'">Delete</button>
                            </div>
                        </div>
                        <customerslist></customerslist> 
                        <div class="modal fade" id="crud" role="dialog" modalentry></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end--><!-- {{tabnav.selected == 'Customers' ? null : 'w-0 gone'}} -->
    <div class="main-sidebar-right hs-100 whtback anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 gone'}}">
        <div class="statusbar grn row align-items-end justify-content-center">
            <h4 class="text-center wht">{{tabnav.selected.name == 'Customers' ? 'Sales Tranx' : 'Sales List'}} <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected.name">
            <div ng-switch-when = 'Sales'>
                <div class = "sidebar-content p-4 w-100">
                    <listsale></listsale>
                </div>
            </div>            
            <div ng-switch-when = 'Customers'>
                <div class = "sidebar-content p-4 w-100">
                    <listtranx></listtranx>
                </div>
            </div>            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
</div>

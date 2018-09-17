<div ng-controller="stocks">
    <div class="prime-hd anim">
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
        <div class="prime-body">
            <div class="animate-switch-container" ng-switch on="tabnav.selected">
                <div class="animate-switch Products px-4 h-100" ng-switch-default>
                    <div class="prodlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Products</h4>
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Add Product'; settings.modal.name = 'Add Product'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Update Product'; settings.modal.name = 'Update Product'; settings.modal.size = 'lg'; " ng-disabled="!stocks.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-disabled="!stocks.jslist.selected" ng-click = "stocks.deleteProduct()">Delete</button></div>
                    </div>
                    <div class="prodlist h-80">
                        <productlist></productlist>
                    </div>
                </div>
                <div class="animate-switch" ng-switch-when="History">HomeSpan</div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end-->
    <div class="main-sidebar-right hs-100 anim">
        <div class="statusbar grn row align-items-end justify-content-center">
            <h4 class="text-center wht">Details <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected">
            <div ng-switch-default>
             <!--<div ng-controller = "ExampleCtrl">
                <ng-croppie  src="inputImage"
                            ng-model='outputImage'
                            update='onUpdate'
                            boundry="{w: 400, h: 400}"
                            viewport="{w: 300, h: 300}"
                            orientation="true"
                            rotation="90"
                            type="circle">
                </ng-croppie>
                <img ng-src="{{outputImage}}" />
                </div>-->
                <div class = "photodetails">
                <div class = "productpic center"></div>
                </div>
                <div class = "discount text-center">
                <div class = "row header">
                    <div class = "anim text-center col-6 py-2 pointer font-weight-bold" ng-click = "details.discount.selected_discount = 'item'" ng-class = "{'btn-warning': details.discount.selected_discount == 'item','dark': details.discount.selected_discount != 'item'}">
                        <h6>Item Discount</h6>
                    </div>
                    <div class = "anim text-center col-6 py-2 pointer font-weight-bold" ng-click = "details.discount.selected_discount = 'total'" ng-class = "{'btn-warning': details.discount.selected_discount == 'total','dark': details.discount.selected_discount != 'total'}">
                        <h6>Total Discount</h6>
                    </div>

                </div>
                <div ng-switch on = "details.discount.selected_discount" class = "w-100 h-70 px-3 discountlist">

                    <div ng-switch-when = "item" class = "w-100">
                    
                    <ul>
                        <li class = "row w-100 b-1 py-4" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud">
                            <div class = "col-4"><div class = "center text-center btn-success"><h4 class = "py-2 m-0">12%</h4></div></div>
                            <div class = "col-8 text-right dark font-weight-bold pr-4 "><h4 class = "m-0">{{3150 | nairacurrency}}</h4></div>
                        </li>
                    </ul>
                    </div>
                    <div ng-switch-when = "total">
                    total
                    </div>
                
                </div>
                <div class="row w-100 justify-content-around">
                <button class="btn w-40 btn-success f-14" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Add Discount'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud">Add Discount</button>
                <button class="btn w-40 btn-danger f-14" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Add Discount'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud">Delete Discount</button>
                </div>
            </div>
            </div>
            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <div class="modal fade" id="crud" role="dialog" modalentry></div>
</div>

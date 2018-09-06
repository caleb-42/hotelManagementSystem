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
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="products.crud = 'Add'">Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="products.crud = 'Update'" ng-disabled="!products.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-disabled="!products.jslist.selected">Delete</button></div>
                    </div>
                    <div class="prodlist">
                        <productlist></productlist>
                    </div>
                </div>
                <div class="animate-switch" ng-switch-when="History">HomeSpan</div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end-->
    <div class="main-sidebar-right hs-100 anim" ng-controller="rightsidebar">
        <div class="statusbar grn row align-items-end justify-content-center">
            <h4 class="text-center wht">Details <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected">
            <div ng-switch-default>
            <div ng-controller = "ExampleCtrl">
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
                </div>
            </div>
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <div class="modal fade" id="crud" role="dialog">
        <div class="modal-dialog modal-md" ng-class="{'modal-md' : products.crud == 'Add', 'modal-lg' : products.crud == 'Update'}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ml-3">{{products.crud}}</h5>
                    <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick=" ">×</button>
                </div>
                <div class="modal-body nopadding">

                    <div class="mx-5 my-4">
                        <form autocomplete="off" class="" ng-if="products.crud == 'Add'">
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="item" />
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Stock" name="current_stock" />
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Price" name="current_price" />
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Description" name="description" />
                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Category" name="category" />
                            <div class="row justify-content-around my-2 align-items-center font-fam-Montserrat">
                                <h6 class="font-fam-Montserrat-bold choral">Shelf Item</h6><span><input type="radio" id = "yes" value = "yes"  name = "shelf_item"/><label for="yes" class = "f-15 ml-2">Yes</label></span><span><input type="radio" value = "no"  name = "shelf_item" id = "no"/><label for="no" class = "f-15 ml-2">No</label></span></div>

                            <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Type" name="type" />
                        </form>
                        <form autocomplete="off" class="" ng-if="products.crud == 'Update'">
                            <div class="w-45 float-left">
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="item" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Stock" name="current_stock" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Price" name="current_price" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Description" name="description" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Category" name="category" />
                                <div class="row justify-content-around my-2 align-items-center font-fam-Montserrat">
                                    <h6 class="font-fam-Montserrat-bold choral">Shelf Item</h6><span><input type="radio" id = "yes" value = "yes"  name = "shelf_item"/><label for="yes" class = "f-15 ml-2">Yes</label></span><span><input type="radio" value = "no"  name = "shelf_item" id = "no"/><label for="no" class = "f-15 ml-2">No</label></span></div>

                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Type" name="type" />
                            </div>
                            <div class="w-45 float-right">
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="item" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Stock" name="current_stock" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Price" name="current_price" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Description" name="description" />
                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Category" name="category" />
                                <div class="row justify-content-around my-2 align-items-center font-fam-Montserrat">
                                    <h6 class="font-fam-Montserrat-bold choral">Shelf Item</h6><span><input type="radio" id = "yes" value = "yes"  name = "shelf_item"/><label for="yes" class = "f-15 ml-2">Yes</label></span><span><input type="radio" value = "no"  name = "shelf_item" id = "no"/><label for="no" class = "f-15 ml-2">No</label></span></div>

                                <input class="form-control font-fam-Montserrat text-center d-block my-4" placeholder="Type" name="type" />
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                            <div class="py-1 row justify-content-center w-100">

                                <button type="button" class="b-0 btn btn-success" ng-click="buyer.customer.selected = buyer.showPanel == 'addnew' ? buyer.customer.jsonform('visitor') : buyer.customer.selectedDefault">
                                    {{products.crud}}
</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

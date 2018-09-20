<div ng-controller="users">
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
                <div class="animate-switch User px-4 h-100" ng-switch-default>
                    <div class="userlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-disabled="!users.jslist.selected">Delete</button></div>
                    </div>
                    <div class="userlist h-80">
                        <userlist></userlist>
                    </div>
                </div>
                <div class="animate-switch" ng-switch-when="History">HomeSpan</div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end-->
    <div class="main-sidebar-right hs-100 anim">
        <div class="statusbar grn row align-items-end justify-content-center">
            <h4 class="text-center wht">Sessions <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected">
            <div ng-switch-default>
                <div class = "sessions">
                
                </div>
            </div>            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <!-- <div class="modal " id="crud" role="dialog" modalentry></div> -->
    <div class="modal " id="crud" role="dialog">
    <div class="modal-dialog modal-{{settings.modal.size}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title ml-3">{{settings.modal.name}}</h5>
            <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick=" ">×</button>
        </div>
        <div class="modal-body nopadding">

    <form class="p-4 w-100 addUserForm row justify-content-center m-0">
                        <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Name" name="user" />
                        <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Username" name="user_name" />
                        <input class="form-control w-75 font-fam-Montserrat text-center d-block my-4" placeholder="Password" name="user_pass" />
                        <div class="row justify-content-between w-50">
                            <span>
                                <input type="radio" id="admin" value="admin" name="role" />
                                <label for="admin" class="f-15 ml-2">Admin</label>
                            </span>
                            <span>
                                <input type="radio" checked value="user" name="role" id="user" />
                                <label for="user" class="f-15 ml-2">User</label>
                            </span>
                        </div>
                    </form>
                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                            <div class="py-1 row justify-content-center w-100">
                                <button type="button" class="b-0 btn btn-success" onclick="addUser()">
                                    {{settings.modal.name | limitTo:3}}
                                </button>
                            </div>
                        </div>
                    </div>
</div>
</div>
</div>
    </div>
</div>

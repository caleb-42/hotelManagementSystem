
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'users'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in users.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (users.jslist.newItemArray = (users.jslist.values | filter:searchbox.imp))" ng-click = "users.jslist.select($index, items.id)" ng-class = "{'actparent' :users.jslist.selected == items.id}">
                <span class = "username col-6">{{items.user_name}}</span>
                <span class = "text-center role col-6">{{items.role}}</span>
            </li>
        </ul>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'sessions'?>">
    <div class = "row hs-80 {{users.jslist.selected ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select A User</h4>
    </div>
    <div class = "listcont {{!users.jslist.selected ? 'gone' : 'notgone'}}">
        <div class = "listhd pr-3 row">
            <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in sessions.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-70 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "session in sessions.jslist.values">
                    <span class = "username col-4">{{session.user_name}}</span>
                    <span class = "text-center login col-4">{{session.logged_on_time}}</span>
                    <span class = "text-center logoff col-4">{{session.logged_off_time}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
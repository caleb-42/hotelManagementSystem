
<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'guest'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in guest.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (guest.jslist.newItemArray = (guest.jslist.values | filter:searchbox.imp))" ng-click = "guest.jslist.select($index, items.id)" ng-class = "{'actparent' :guest.jslist.selected == items.id}">
                <span class = "username col-6">{{items.user_name}}</span>
                <span class = "text-center role col-6">{{items.role}}</span>
            </li>
        </ul>
    </div>
</div>
<!-- ............jslist start ..............-->


<!-- ............cartitems start ..............-->
<div ng-if = "<?php echo $_GET['type']   == 'accordion'?>" class = "h-100" >
    <div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
        <h5 class="mb-0 pointer p-3 py-2 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Check in
        </h5>
        </div>

        <div id="collapseOne" class="collapse show px-2" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">
               <form autocomplete = "off" class = 'px-2 row align-items-center'>
                   <label class = "f-13 col-4">Name</label>
                   <input name = "guest_name" class = "form-control col-8"/>
                   <label class = "f-13 col-4">Name</label>
                   <input name = "guest_name" class = "form-control col-8"/>
                   <label class = "f-13 col-4">Name</label>
                   <input name = "guest_name" class = "form-control col-8"/>
                   <label class = "f-13 col-4">Name</label>
                   <input name = "guest_name" class = "form-control col-8"/>
                   <label class = "f-13 col-4">Name</label>
                   <input name = "guest_name" class = "form-control col-8"/>
               </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header " id="headingTwo">
        <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Update Guest Info
        </h5>
        </div>
        <div id="collapseTwo" class="collapse px-2" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
        <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Check out
        </h5>
        </div>
        <div id="collapseThree" class="collapse px-2" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
        </div>
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
<style>
    .md-select-menu-container,
   md-backdrop {
       z-index: 999999 !important;
   }
</style>
    
    
        <div class="card">
            <div class="card-header border-bottom header-elements-inline">
                <h5 class="card-title" style="text-transform:capitalize;">[[department_name?department_name:'Department']] Services Stats
                    <span><a href="#" class="" ng-click="showFilter()">
                        <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
                   </a></span>
                </h5>
                <div class="header-elements">
                    <div class="row m-0">
                        <div class="col-md-12">
                            <md-select ng-change="filterByDate(date_filter)" name="date_filter" class="m-0" ng-model="date_filter" placeholder="Today's Tasks">
                                <md-option ng-value="'today'">Today's tasks</md-option>
                                <md-option ng-value="'previous'">Previous tasks</md-option>
                            </md-select>
                        </div>
                    </div>
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row m-0">
                    <div class="col-md-4">       
                        <div class="card card-body bg-warning has-bg-image" style="max-height: 75px;">
                            <div class="media">
                                <div class="media-body">
                                    <h2 class="mb-0 font-weight-bold"><span id="stats_assign"></span>[[counts.todo]]</h2>
                                    <span class="text-uppercase font-size-xs">Assign Tasks</span>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <i class="icon-list-numbered icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-md-4">       
                        <div class="card card-body bg-info has-bg-image" style="max-height: 75px;">
                            <div class="media">
                                <div class="media-body">
                                    <h2 class="mb-0 font-weight-bold"><span id="stats_completed"></span>[[counts.inprogress]]</h2>
                                    <span class="text-uppercase font-size-xs">Inprogress Tasks</span>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <i class="icon-hammer-wrench fa-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-md-4">
                            <div ng-messages="hotelForm.company_id.$error" ng-if='hotelForm.company_id.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Company is required</div>
                            </div>
                        <div class="card card-body bg-success has-bg-image" style="max-height: 75px;">
                            <div class="media">
                                <div class="media-body">
                                    <h2 class="mb-0 font-weight-bold"><span id="stats_completed"></span>[[counts.completed]]</h2>
                                    <span class="text-uppercase font-size-xs">Completed Tasks</span>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <i class="fa fa-check-double fa-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>


        <div class="card">
            <div class="card-body">
                <div class="row m-0">
                    <div class="col-md-4  d-flex">       
                        <div class="card border-top-1 border-top-warning flex-fill">
                            <div class="card-header text-center border-bottom">
                                <div class="card-title">
                                    <h6 class="font-weight-semibold mb-0"> <i class="icon-list-numbered mr-1 text-warning"></i> To Do List</h6>
                                </div>
                            </div>
                            <div id="todo" class="card-body dropdown-men dropdown-menu-sortable" style="display: block; position: static; width: 100%; margin-top: 0; float: none;">
                
                                <div id="[[task]]" ng-repeat="task in tasks | filter :{status:'todo'} " href="#" class="py-1 px-0  my-1 task-container">
                                    
                                    <div class="row border-bottom pb-2">
                                        <div class="col-md-8">
                                            <span ng-if="[[task.booking_service.icon_class]]"><img src="[[task.booking_service.icon_class]]" width="40" height="40" alt="" class="img-thumnbnail img-fluid"></span>
                                            <strong class="d-inline-block">
                                                [[task.service]]<span ng-if="[[task.room_id]]"> | [[task.room_title]] (Room# [[task.RoomNumber]])</span> <span ng-if="[[task.service_id]]"> | Qty :[[task.booking_service.times]]</span>
                                            </strong>

                                            

                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span class="cursor-pointer" data-popup="popover" title="" data-trigger="hover" data-html="true"
                                                            data-content="<div><b>Hotel</b>: [[task.HotelName]]</div>
                                                              <div ng-if='[[task.booking_id]]'><b>Booking #</b> : [[task.booking_no]] </div>
                                                              <div ng-if='[[task.room_id]]'><b>Room</b> : [[task.room_title]] (Room# [[task.RoomNumber]])</div>
                                                              <div ng-if='[[task.service_id]]'><b>Service</b> : [[task.service]] </div>
                                                              <div ng-if='[[task.service_id]]'><b>Quantity</b> : [[task.booking_service.times]] </div>
                                                              <div ng-if='[[task.service_id]]'><b>Service Date</b> : [[task.booking_service.created_at |date]] </div>
                                                            "
                                                            data-original-title=""><i class="icon-info22"></i>
                                            </span>
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu"></i></a>
                                                <div class="dropdown-menu p-1">
                                                    <a ng-click="statusUpdate(task, 'inprogress', 'todo')" class="dropdown-item p-0"><i class="icon-sync mr-1 text-info"></i>Move to Inprogress</a>
                                                    <a ng-click="statusUpdate(task, 'completed', 'todo')" class="dropdown-item p-0"><i class="icon-check mr-1 text-success"></i>Move to Completed</a>
                                                </div>
                                            </div>                                            
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label class="col-md-4 col-form-label"> BTC</label>
                                            
                                                <md-switch ng-model="data.isSelected" ng-click="statusUpdatebtc(data.isSelected)"  style="display:block" ></md-switch>
                                         
                                        </div>
                                 
                                        <!-- <md-switch  aria-label="Switch 1"  ng-class="data.cssClass">
                                        -->
  <!-- </md-switch> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-md-4  d-flex">       
                        <div class="card border-top-1 border-top-info flex-fill">
                            <div class="card-header text-center border-bottom">
                                <div class="card-title">
                                    <h6 class="font-weight-semibold mb-0"><i class="icon-hammer-wrench mr-1 text-info"></i> Inprogress</h6>
                                </div>
                            </div>
                           
                            <div id="inprogress" class="card-body dropdown-men dropdown-menu-sortable" style="display: block; position: relative; width: 100%; margin-top: 0; float: none;">
                                <div id="[[task]]" ng-repeat="task in tasks | filter :{status:'inprogress'} " href="#" class="py-1 px-0  my-1 task-container">
                                    <div class="row border-bottom pb-2">
                                        <div class="col-md-8">
                                            <span><img src="[[task.booking_service.icon_class]]" width="40" height="40" alt="" class="img-thumnbnail img-fluid"></span>
                                            <strong class="d-inline-block">
                                                [[task.service]]<span ng-if="[[task.room_id]]"> | [[task.room_title]] (Room# [[task.RoomNumber]])</span> <span ng-if="[[task.service_id]]"> | Qty :[[task.booking_service.times]]</span>
                                            </strong>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span class="cursor-pointer" data-popup="popover" title="" data-trigger="hover" data-html="true"
                                                            data-content="<div><b>Hotel</b>: [[task.HotelName]]</div>
                                                              <div ng-if='[[task.booking_id]]'><b>Booking #</b> : [[task.booking_no]] </div>
                                                              <div ng-if='[[task.room_id]]'><b>Room</b> : [[task.room_title]] (Room# [[task.RoomNumber]])</div>
                                                              <div ng-if='[[task.service_id]]'><b>Service</b> : [[task.service]] </div>
                                                              <div ng-if='[[task.service_id]]'><b>Quantity</b> : [[task.booking_service.times]] </div>
                                                              <div ng-if='[[task.service_id]]'><b>Service Date</b> : [[task.booking_service.created_at |date]] </div>
                                                            "
                                                            data-original-title=""><i class="icon-info22"></i>
                                            </span>
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu"></i></a>
                                                <div class="dropdown-menu p-1">
                                                    <a ng-click="statusUpdate(task, 'todo', 'inprogress')" class="dropdown-item p-0"><i class="icon-sync mr-1 text-warning"></i>Move to Todo</a>
                                                    <a ng-click="statusUpdate(task, 'completed', 'inprogress')" class="dropdown-item p-0"><i class="icon-check mr-1 text-success"></i>Move to Completed</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    
        
                    <div class="col-md-4  d-flex">
                        <div class="card border-top-1 border-top-success flex-fill">

                            <div class="card-header text-center border-bottom">
                                <div class="card-title">
                                    <h6 class="font-weight-semibold mb-0"> <i class="fa fa-check-double mr-1 text-success"></i> Completed</h6>
                                </div>
                            </div>
                            
                            <div id="completed" class="card-body dropdown-men dropdown-menu-sortable" style="display: block; position: relative; width: 100%; margin-top: 0; float: none;">
                                <div id="[[task]]" ng-repeat="task in tasks | filter :{status:'completed'} " href="#" class=" py-1 px-0  dropdown-item my-1 task-container ">
                                    <div class="col-md-8">
                                            <span><img src="[[task.booking_service.icon_class]]" width="40" height="40" alt="" class="img-thumnbnail img-fluid"></span>
                                            <strong class="d-inline-block">
                                                [[task.service]]<span ng-if="[[task.room_id]]"> | [[task.room_title]] (Room# [[task.RoomNumber]])</span> <span ng-if="[[task.service_id]]"> | Qty :[[task.booking_service.times]]</span>
                                                
                                            </strong>
                                    </div>
                                    <div class="col-md-4 text-right">
                                                        <span class="cursor-pointer" data-popup="popover" title="" data-trigger="hover" data-html="true"
                                                            data-content="<div><b>Hotel</b>: [[task.HotelName]]</div>
                                                              <div ng-if='[[task.booking_id]]'><b>Booking #</b> : [[task.booking_no]] </div>
                                                              <div ng-if='[[task.room_id]]'><b>Room</b> : [[task.room_title]] (Room# [[task.RoomNumber]])</div>
                                                              <div ng-if='[[task.service_id]]'><b>Service</b> : [[task.service]] </div>
                                                              <div ng-if='[[task.service_id]]'><b>Quantity</b> : [[task.booking_service.times]] </div>
                                                              <div ng-if='[[task.service_id]]'><b>Service Date</b> : [[task.booking_service.created_at |date]] </div>
                                                            "
                                                            data-original-title=""><i class="icon-info22"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
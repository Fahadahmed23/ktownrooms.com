
<style>
    .service-img-col img{
        height: 60px;
        border-radius: 100%;
        width: 60px;
    }

    .popover-header {
    padding: 5px 10px !important;
    }
    .popover-body {
    padding: 12px;
    }
    .cancel_service_reason_input {
    border: 1px solid #cccaca !important;
    }   
</style>
<div id="showRequest_Complains" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header pt-1">
				<button type="button" class="close" ng-click="hideRequest_Complains()">&times;</button>
			</div>

            <div class="modal-body  ">
                <ul class="nav nav-tabs nav-tabs-bottom nav-tabs-highlight nav-justified">

                    @auth
                    <li class="nav-item"><a id="c_table-tab" href="#mycomplain-tab" class="nav-link" data-toggle="tab"> <i class="icon-book mr-2"></i>Complains</a></li>
                    <li class="nav-item"><a id="r_table-tab" href="#myrequest-tab" class="nav-link" data-toggle="tab"> <i class="icon-book mr-2"></i>Availed Services</a></li>
                    
                    @endauth

                    @guest
                    <li class="nav-item"><a id="c_table-tab" href="#mycomplain-tab" class="nav-link" data-toggle="tab"> <i class="icon-book mr-2"></i>My Complains</a></li>
                    <li class="nav-item"><a id="r_table-tab" href="#myrequest-tab" class="nav-link" data-toggle="tab"> <i class="icon-book mr-2"></i>My Availed Services</a></li>
                    @endguest
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="mycomplain-tab">
                        <div class="card-body p-0" style="height: 400px;overflow: auto;">
                            <div class="row" >
                                <div class="col-lg-6" ng-repeat="complain in cutomers_complains">
                                    <div ng-class="getStatusClass(complain.status.ComplainStatus)" class="card border-left-3 border-left-danger rounded-left-0" style="min-height: 180px;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="mb-0"><strong>Complain Code: </strong>[[complain.complain_code]]</p>
                                                    <p class="mb-0"><strong>Subject: </strong>[[complain.subject]]</p>
                                                    <p ng-if="complain.message" class="mb-0 px-0 "><strong>Complain: </strong></p>
                                                    <p class="mb-0 px-0" style="height: 50px;overflow: auto;">[[complain.message]]</p>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                                            <span>
                                                <span class="mr-1">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                                Complain Time :
                                                <span class="font-weight-semibold">[[complain.ComplainTime | date]]</span>
                                            </span>
                                            <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                                                                    
                                                <li class="list-inline-item" >Status:
                                                    <a href="javascript:void(0)" ng-class="complain.status.style_class" class="text-default badge" data-toggle="dropdown">[[complain.status.ComplainStatus]]</a>    
                                                </li> 
                                            
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>

                    <div class="tab-pane fade" id="myrequest-tab">
                        <div class="card-body p-0">
                            <div class="card-body p-0" style="height: 400px;overflow: auto;">
                                <div class="row" >
                                    <div class="col-md-12" ng-repeat="request in booking_service">
                                        <div ng-class="getBserBorder(request.status)" class="card border-left-3  rounded-left-0">
                                            <div class="card-header border-bottom">
                                                <div class="row">
                                                    <div class="col-md-6 mt-2">
                                                        <span class="title-service">
                                                            <strong><span class="service-img-col mr-2"><img src="[[request.icon_class]]" class="img-thumbnail img-fluid" alt=""></span> <span>[[request.service_name]]</span></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <div class="col-md-12">
                                                            <i class="icon-info22" data-placement="right" data-popup="popover" title="Service Detail" data-trigger="hover" data-html="true"
                                                            data-content="
                                                            <ul class='tool-tip-list-item'>
                                                                <li><span>Department : [[request.department_name]]</span></li>
                                                                <li><span>Hotel : [[request.room.HotelName]]</span></li>
                                                                <li><span>Start Time : <span class='ml-1'><i class='fa fa-clock' aria-hidden='true'></i></span> [[request.start_time]]</span></li>
                                                                <li><span>End Time : <span class='ml-1'><i class='fa fa-clock' aria-hidden='true'></i></span> [[request.end_time]]</span></li>
                                                                <li><span>Serving Time : <span class='ml-1'><i class='fa fa-clock' aria-hidden='true'></i></span> [[request.serving_time]]</span></li>
                                                                <li><span>Request Time : <span class='mx-1'><i class='fa fa-calendar' aria-hidden='true'></i></span><span class='font-weight-semibold'>[[request.created_at | date]]</span> </span></li>
                                                                <li><span>Room: [[request.room.room_title]]</span></li>
                                                                <li><span>Room Category : </span><span class='badge text-white' style='background-color:[[request.room.category.Color]]'>[[request.room.RoomCategory]]</span></li>
                                                            </ul>" data-original-title="Popover title">
                                                            </i>
                                                        </div>
                                                        <div class="col-md-12 ">
                                                            <p class="mb-0"><strong>Charges: </strong>[[request.service_charges | currency]]</p>
                                                        </div>
                                                        <div class="col-md-12 ">
                                                            <p class="mb-0"><strong>Status: </strong> <span ng-class="getBserviceStatus(request.status)" class="badge">[[request.status]] <i ng-class="getBserIcon(request.status)" class="fa-1x ml-1"></i></span></p>
                                                        </div>

                                                        <div class="col-md-12" ng-if="request.cancel_reason">
                                                            <p class="mb-0"><strong>Reason: </strong> <span>[[request.cancel_reason]]</span></p>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <div ng-show="user_frontdesk" class="ser-scpt-rjct-btn">
                                                            <button ng-show="request.status == 'awaiting'" ng-click="acceptRejectBookingService(request.id , 'accepted')" class="btn btn-success">Accept <i class="icon-check ml-1"></i></button>
                                                            <button ng-show="request.status == 'awaiting'" ng-click="acceptRejectBookingService(request.id, 'rejected')" class="btn btn-danger">Reject <i class="icon-close2 ml-1"></i></button>
                                                            <button  ng-show="request.status == 'accepted'" type="button" class="btn btn-danger service_cancel_btn" data-popup="popover" title="Cancel Reason" data-html="true" 
                                                                data-content="
                                                                    <div class='row mt-2'> 
                                                                        <div class='col-md-12'>
                                                                            <input id='cancel_service_reason_input' type='text' class='form-control cancel_service_reason_input'>
                                                                        </div>
                                                                    </div>
                                                                    <div class='row my-2'> 
                                                                        <div class='col-md-12'>
                                                                            <button data-id=[[request.id]] class='btn btn-info cancl_btn' type='button'> Yes</button>
                                                                            <button type='button' class='btn btn-danger close-popover'>No</button>
                                                                        </div>
                                                                    </div>    
                                                                    ">Cancel <i class="icon-close2 ml-2"></i>
                                                            </button>
                                                        </div>


                                                        <div ng-hide="user_frontdesk" class="ser-cancel-btn">
                                                            <button  ng-show="request.status == 'awaiting'" type="button" class="btn btn-danger service_cancel_btn" data-popup="popover" title="Cancel Reason" data-html="true" 
                                                                data-content="
                                                                    <div class='row mt-2'> 
                                                                        <div class='col-md-12'>
                                                                            <input id='cancel_service_reason_input' type='text' class='form-control cancel_service_reason_input'>
                                                                        </div>
                                                                    </div>
                                                                    <div class='row my-2'> 
                                                                        <div class='col-md-12'>
                                                                            <button data-id=[[request.id]] class='btn btn-info cancl_btn' type='button'> Yes</button>
                                                                            <button type='button' class='btn btn-danger close-popover'>No</button>
                                                                        </div>
                                                                    </div>    
                                                                    ">Cancel <i class="icon-close2 ml-2"></i>
                                                            </button>
                                                        </div>
                                                
                                                                                                                 
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-top pt-3">
                <div class="text-right">
                    <button type="button" ng-click="createServiceRequest(departments[0].id)" class="btn btn-sm bg-warning"><i class="fas fa-concierge-bell mr-1"></i>Request for Services</button>
                </div>
            </div>


			
		</div>
	</div>
</div>
<script>
    $(document).on('click', '.cancl_btn', function() {
        console.log($(this).attr("data-id") );
        //  return;
          let cancel_reason = $("#cancel_service_reason_input").val();
          let service_id = $(this).attr("data-id");
        angular.element(document.querySelector('[ng-controller="housekeepingCtrl"]')).scope().cancelBookingService(service_id,cancel_reason);
    })
    $(document).on("click", ".close-popover" , function(){
        $(this).parents(".popover").popover('hide');
    });
</script>

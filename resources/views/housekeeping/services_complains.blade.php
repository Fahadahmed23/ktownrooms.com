
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

    .service-detail div {
    display: inline;
    }
    .tool-tip-list-item {
    padding-left: 0;
    list-style: none;
    }
    .desktop-text-right {
    text-align: right;
    }
    @media only screen and (max-width: 767px){
    .b-service-pills {
        text-align: center !important;
    }
    .service-action-btn {
    margin: 5px 0;
    }
    .desktop-text-right {
    text-align: center;
    }
    .service-detail-colpse{
        text-align: left;
    }
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
                                <div class="col-md-12" ng-repeat="complain in cutomers_complains">
                                    <div ng-class="getStatusClass(complain.status.ComplainStatus)" class="card b-service-pills border-left-3 p-2 rounded-left-0">
                                        <div class="row m-0 bg-light p-2">
                                            <div class="service-detail col-md-7">
                                                <div class="complain-title">
                                                    <a href="#collap-[[complain.id]]" data-toggle="collapse"><span><b>[[complain.complain_code]]</b></span></a>
                                                </div> 
                                                | 
                                                <div class="comlain-subject">
                                                    <span><b>Sub: [[complain.subject]]</b></span>
                                                </div>
                                                |
                                                <div class="complain-date">
                                                    <span><b>Date: [[complain.ComplainTime | date]]</b></span>
                                                </div>
                                            </div>

                                            <div class="col-md-5 desktop-text-right">
                                                <div class="service-status">
                                                    <span><b>Status: </b><a href="javascript:void(0)" ng-class="complain.status.style_class" class="text-default badge" data-toggle="dropdown">[[complain.status.ComplainStatus]]</a></span>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-12">
                                                <div class="collapse service-detail-colpse  mt-2 border-top" id="collap-[[complain.id]]">
                                                    <div class="mt-1">
                                                        <ul class='tool-tip-list-item '>
                                                            <li><span><b>Complain </b>: [[complain.message]]</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>

                    <div class="tab-pane fade" id="myrequest-tab">
                            <div class="card-body p-0" style="height: 400px;overflow: auto;">
                                <div class="row" >
                                    <div class="col-md-12" ng-repeat="request in booking_service">
                                        <div ng-class="getBserBorder(request.status)" class="card b-service-pills border-left-3 p-2 rounded-left-0">
                                            <div class="row m-0 bg-light p-2">
                                                <div class="service-detail col-md-7">
                                                    <div class="title-service ">
                                                       <a href="#collapse-[[request.id]]" data-toggle="collapse"><span><b>[[request.service_name]]</b></span></a>
                                                    </div> 
                                                    | 
                                                    <div class="service-times">
                                                        <span><b>Qty: [[request.times]]</b></span>
                                                    </div>
                                                    |
                                                    <div class="service-charges">
                                                        <span><b>Charges: [[request.amount | currency]]</b></span>
                                                    </div>
                                                    |
                                                    <div class="service-date">
                                                        <span><b>Date: [[request.created_at | date]]</b></span>
                                                    </div>
                                                </div>

                                                <div class="[[request.status=='completed' || request.status=='cancelled' ||  request.status=='rejected'? 'col-md-5' : 'col-md-3']] desktop-text-right">
                                                    <div class="service-status">
                                                        <span><b>Status: </b> <span ng-class="getBserviceStatus(request.status)" class="badge">[[request.status]] <i ng-class="getBserIcon(request.status)" class="fa-1x ml-1"></i></span></span>
                                                    </div>
                                                </div>

                                                <div ng-hide="user_frontdesk || request.status == 'completed '" class="ser-cancel-btn col-md-2 text-center actionbtnservice">
                                                    <div class="service-action-btn">
                                                            <a href="javascript:void(0)" ng-show="request.status == 'awaiting'" type="button" class="service_cancel_btn text-danger" data-popup="popover" title="Cancel Reason" data-html="true" 
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
                                                                "><i class="icon-close2 ml-2"></i>
                                                            </a>
                                                    </div>
                                                </div>

                                                <div ng-show="user_frontdesk || request.status == 'completed '" class="ser-scpt-rjct-btn col-md-2 text-center actionbtnservice">
                                                    <a href="javascript:void(0)" ng-show="request.status == 'awaiting'" ng-click="acceptRejectBookingService(request.id , 'accepted')" class="text-success" data-placement="top" data-popup="popover" data-trigger="hover" data-content="Accept Service" data-original-title="" title=""><i class="icon-check ml-1"></i></a>
                                                    <a href="javascript:void(0)" ng-show="request.status == 'awaiting'" ng-click="acceptRejectBookingService(request.id, 'rejected')" class="text-danger"  data-placement="top" data-popup="popover" data-trigger="hover" data-content="Reject Service" data-original-title="" title=""><i class="icon-close2 ml-1"></i></a>
                                                    <a href="javascript:void(0)" ng-show="request.status == 'accepted'" type="button" class="btn btn-danger service_cancel_btn" data-popup="popover" title="Cancel Reason" data-html="true" 
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
                                                            "><i class="icon-close2 ml-2"></i>
                                                    </a>
                                                </div>

                                               
                                                <div class="col-md-12">
                                                    <div class="collapse service-detail-colpse  mt-2 border-top" id="collapse-[[request.id]]">
                                                        <div class="mt-1">
                                                            <ul class='tool-tip-list-item '>
                                                                <li><span><b>Room </b>: [[request.room.room_title]] (Room# [[request.room.RoomNumber]])</span></li>
                                                                <li><span><b>Room Category</b>: </span>[[request.room.RoomCategory]]</li>
                                                                <li><span><b>Hotel </b>: [[request.room.HotelName]]</span></li>
                                                                <li><span><b>Department </b>: [[request.department_name]]</span></li>
                                                            
                                                            </ul>
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

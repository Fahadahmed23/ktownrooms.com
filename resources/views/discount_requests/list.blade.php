<div class="row">


    <div class="col-lg-12" dir-paginate="comp in [1] | itemsPerPage:perPage" current-page="currentPage" total-items="TotalRecords" pagination-id="complainPagination" ng-cloak>
        <div class="row" >
            <div class="col-lg-4" ng-repeat="discount_request in discount_requests">
                <div ng-class="getStatusClassForBorder(discount_request.status)" class="card border-left-3 border-left-danger rounded-left-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p ng-hide="user.is_frontdesk" class="mb-0"><strong>Requested By: </strong>[[discount_request.requester.name]]</p>
                                <p class="mb-0"><strong>Requested Amount: </strong>[[discount_request.requested_amount |currency]]</p>
                                <p class="mb-0"><strong>Allowed Amount: </strong>[[discount_request.allowed_discount |currency]]</p>
                                <span ng-show="user.is_frontdesk">
                                    <p class="mb-0"><strong>[[discount_request.status]] By :  </strong>[[discount_request.supervisor.name]]</p>
                                    <p class="mb-0"><strong>Reason:  </strong>[[discount_request.supervisor_comments]]</p>
                                </span>
                            </div>
    
                            <div class="text-sm-right col-md-6">
                                <p class="mb-0"><strong>Booking # </strong> <span>[[discount_request.booking.booking_no]]</span></p>
                                <p class="mb-0"><strong>Customer Name: </strong>[[discount_request.booking.invoice.customer_first_name]] [[discount_request.booking.invoice.customer_last_name]]</p>  
                            </div>
                        </div>
                    </div>


                    <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                        
                        <span>
                            <span class="mr-1">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </span>
                           Request Date :
                            <span class="font-weight-semibold">[[discount_request.created_at | date]]</span>
                        </span>
                        <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                            <li class="list-inline-item">
                                <button class="invoicebtn border-0 p-0" ng-click="showInvoice(discount_request.booking_id)"  type="button" style="background:transparent" data-placement="top" class="btn btn-light" data-popup="popover" title="[[nBook.room_title]]" data-trigger="hover" data-html="true"
                                data-content="View Booking Info"
                                data-original-title="Popover title"><i class="icon-clipboard3"></i></button>
                            </li>

                             <li ng-hide="user.is_frontdesk" class="list-inline-item dropdown" >Status:
                                <a href="javascript:void(0)" ng-class="getStatusClass(discount_request.status)" class="text-default dropdown-toggle badge [[discount_request.status]]" data-toggle="dropdown">[[discount_request.status]]</a>

                                <div  class="dropdown-menu dropdown-menu-right">
                                    <!-- <a href="javascript:void(0)" ng-click="changeStatus(discount_request.id, 'Pending')" class="dropdown-item"></i>Pending</a> -->
                                    <a href="javascript:void(0)" ng-click="changeStatus(discount_request.id, 'Approved')" class="dropdown-item"></i>Approve</a>
                                    <a href="javascript:void(0)" ng-click="changeStatus(discount_request.id, 'Declined')" class="dropdown-item"></i>Decline</a>
                                </div>
                            </li> 

                            <li ng-show="user.is_frontdesk" class="list-inline-item" >Status:
                                <a href="javascript:void(0)" ng-class="getStatusClass(discount_request.status)" class="text-default badge [[discount_request.status]]" data-toggle="dropdown">[[discount_request.status]]</a>    
                            </li> 
                        
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<dir-pagination-controls pagination-id="complainPagination" on-page-change="pageChanged(newPageNumber)" direction-links="true" boundary-links="true"></dir-pagination-controls>
<style>
    .card-footer {
    overflow: auto;
}
.room-detail-row label{
    margin: 0;
    width:100%;
}
    .btn-number[data-type='minus']:disabled,
    .btn-number[data-type='plus']:disabled {
        cursor: no-drop;
    }
    
    .show-de,
    .hide-de {
        cursor: pointer;
    }
    
    .see-more {
        position: relative;
        cursor: pointer;
    }
    
    .selected-room {
        cursor: url(http://localhost:8000/global_assets/images/close.cur),pointer;
        width: 100%;
        height: 100%;
        position: absolute;
        display: none;
        background-color: #ff000085;
        /* background-color: #4caf5026; */
        z-index: 9;
        text-align: center;
        justify-content: center;
        align-items: center;
    }
    /* .booked-room{
        cursor: pointer;
        width: 100%;
        height: 100%;
        position: absolute;
        display: flex;
        /* background-color: #ff000085; */
        background-color: #4caf5026;
        z-index: 9;
        text-align: center;
        justify-content: center;
        align-items: center;
        cursor: no-drop;
    } */
    
    .B-Confirm {
        cursor: pointer;
    }
    
    /* .selected-room h1 {
        color: #fff;
        border: 2px solid #fff;
        padding: 5px 15px;
    } */

    .selected-room h1 {
    color: #ffffff;
    /* border: 2px solid #4caf50; */
    border: 2px solid #fff;
    padding: 5px 15px;
    /* background: #4caf50de; */
    width: 100%;
}
    
.booked-room h1 {
    color: #ffffff;
    /* border: 2px solid #4caf50; */
    border: 2px solid #fff;
    padding: 5px 15px;
    /* background: #4caf50de; */
    width: 100%;
    display: none;
}
    .see-more:before {
        border-top: 8px solid #6f6e6e;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        content: "";
        height: 0;
        left: -10px;
        position: absolute;
        top: 19px;
        width: 0;
        margin-left: 50%;
    }
    
    .arrow-up {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid black;
    }
    
    .receipt {
        position: relative;
        background: #f5f5f5;
    }
    
    .zig-zag-top:before {
        background: linear-gradient(-45deg, #f5f5f5 16px, red 16px, blue 16px, transparent 0), linear-gradient(45deg, #f5f5f5 16px, transparent 0);
        background-position: left top;
        background-repeat: repeat-x;
        background-size: 17px 36px;
        content: " ";
        display: block;
        height: 21px;
        width: 100%;
        position: relative;
        bottom: 21px;
        left: 0;
    }
    
    .gad-event-info {
        color: #000 !important;
        pointer-events: none;
    }
    
    .gad-event-info .fc-content {
        white-space: inherit;
        color: #000;
    }
    
    .gad-event-info .fc-content span {
        display: block;
    }
    
    .cell-info {
        color: #000 !important;
        pointer-events: none;
    }
    
    .col-form-label {
        padding-right: 0px;
    }
    
    .filter {
        display: none !important;
    }
    
    .media-list-linked {
        overflow-y: auto;
    }
    
    .visitor-modal {
        max-height: 80vh;
        overflow-y: auto;
    }
    .room_mini_card {
    min-height: 175px;
    cursor: pointer;
    }
    .room_mini_card a:hover {
    color: inherit !important;
    }
    /* .no-cursor a{
        cursor: no-drop;
    } */
    .room-detail-row{
        width: 100%;
        padding: 0 10px;
        border-bottom: 1px dashed #eee;
    }
    .room-detail-row ul{
        list-style: none;
    }

    #customerDetail .customercard{
        margin-bottom: 0 !important;
    }
</style>



<!--Available Rooms-->
<div id="rooms-available" class="show-rooms" style="display:none">
 <div class="" style=" width: 100%;display: flex;">
        <div class="room-container col-lg-12 p-0">
            <div class="card" style="width: 100%;padding: 15px 10px 0 10px;">
                <div class="row">
                    <!-- <div ng-repeat="room in rooms" class="col-sm-4 col-xl-3 float-left"> -->
                        <div ng-repeat="room in rooms" class="col-md-4 float-left">
                        <div class="card [[room.st.card_style]] room_mini_card [[room.st.cursor]]">
                            <span id="room[[room.id]]" ng-if="room.st.name == 'Booked'" class="booked-room" >
                                <h1><i class="icon-check mr-1 icon-2x"></i>[[room.st.name]]</h1>
                            </span>

                            <div id="room[[room.id]]" class="selected-room" ng-click="deselectRoom(room)">
                                <h1><i class="icon-check mr-1 icon-2x"></i>Reserved</h1>
                            </div>
                            
                            <a href="javascript:void(0)" ng-click="selectRoom(room)" class="[[room.st.text_style]]">
                                <div class="card-body">
                                    <div class="row m-0">
                                        <div class="col-md-6">
                                            <div class="row py-1">
                                                <div class="col-lg-12">
                                                    <h6 class="mt-2 mb-0">[[room.RoomCharges | currency]] / Night</h6>
                                                </div>
                                                <div class="col-lg-12">
                                                    Allowed Occupants: [[room.hotel_room_category.allowed]]
                                                </div>
                                                <div class="col-lg-12">
                                                    Max. Allowed Occupants: [[room.hotel_room_category.max_allowed]]
                                                </div>
                                                <div class="col-lg-12">
                                                    Additional Guest Charges: [[room.hotel_room_category.additional_guest_charges | currency]] / Night
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media-body text-right">
                                                <span  class="text-uppercase font-size-xs badge text-white" style="background-color:[[room.category.Color]]">[[room.hotel_room_category.CategoryName]]</span>
                                                <h3 class="mb-0">[[room.room_title]]</h3>
                                                <div>Room# [[room.RoomNumber]]</div>
                                                 <span class="text-uppercase font-size-xs">[[room.st.name]]</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-around text-center p-0" style="display: none !important;">
                                    <a ng-repeat="facility in room.facilities" href="#" class="[[room.st.text_style]]  list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="[[facility.Facility]]">
                                        {{-- <i class="[[facility.IconPath]] top-0"></i> --}}
                                        <img ng-if="facility.Image" width="30px" height="auto" ng-src="[[facility.Image]]">
                                    </a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 pr-lg-0 selected-rm-detail" ng-show="nBooking.rooms">
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Room Details</span>
                </div>

                <div class="list-group list-group-flush">
                    <a ng-repeat="room in nBooking.rooms" class="list-group-item list-group-item-action legitRipple p-1">
                        <div class="room-detail-row" style="width: 100%">
                            <div class="row">
                                <div class="col-md-12">
                                    <label><span><i class="icon-city mr-1"></i></span> <span>[[room.room_title]] (Room# [[room.RoomNumber]])</span></label>
                                    <label><small>Category:</small> <small>[[room.RoomCategory]]</small></label>
                                    <label><span><i class="icon-cash4 mr-1"></i></span> <small>[[room.RoomCharges | currency]]/Night</small></label>
                                </div>
                                {{-- <div class="col-md-6">
                                    <span>
                                        <i class="icon-city mr-1"></i> <span>[[room.room_title]]</span>
                                    </span>
                                    <span class="d-block mt-1"> <ul class="mb-0 p-0"><li><small>Category:</small> <small>[[room.RoomCategory]]</small></li></ul></span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="">[[room.RoomCharges | currency]]/Night</span>
                                </div> --}}
                            </div>
                        </div>
                    </a>

                    <a class="list-group-item list-group-item-action legitRipple p-1">

                        <div class="room-detail-row p-2" style="width: 100%">
                            <div class="row">
                                <div class="col-md-6">
                                    <span>
                                        <strong>Total</strong>
                                    </span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="">[[nBooking.invoice.total | currency]]</span>
                                </div>
                            </div>
                        </div>
                        
                    </a>
                </div>

                <div class="card-body">
                    <div class="text-right mt-3">
                        <button ng-click="showBookForm(nBooking)" class="legitRipple btn btn-info">
                            <i class="icon-paperplane mr-2"></i>
                            <strong>Proceed</strong>
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!--/Available Rooms-->

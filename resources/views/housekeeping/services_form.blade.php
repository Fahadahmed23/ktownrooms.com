<style>
/* .tool-tip-list-item {
    padding-left: 10px;
} */
.services-boxes-row{
    margin-top: 0px;
    max-height: 250px;
    overflow: auto;
}
.services-boxes-row::-webkit-scrollbar {
  width: 1px;
}

.services-boxes-row::-webkit-scrollbar-track {
  background: #dddddd;
}
.services-boxes-row::-webkit-scrollbar-thumb {
    background-color: #4caf51;
    border: 1px solid #4caf51;
}
.text-teal img{
    height: 60px;
    border-radius: 100%;
    width: 60px;
}
.number-input.number-input {
    border-radius: 1.25rem;
    background: #eeeded;
}
.cart-service-title-col {
    width: 60%;
    float: left;
    padding: 5px;
}
.cart-service-icon-col {
    width: 20%;
    float: left;
}
.cart-service-icon {
    width: 100%;
    border-radius: 100%;
}
.cart-service-remove-btn {
    width: 20%;
    text-align: right;
    float: left;
}
.depatmentstabs img {
    width: 70px;
    height: 70px;
}
/* .inc_dec_btns{
    position: absolute;
    top: 25%;
} */
.number-input input.quantity.form-control {
    background: #fff;
}
@media only screen and (max-width: 767px) {

.service-icon-col {
    text-align: center;
    margin: 12px 0px 0px 0px !important;
}
.services-cart {
    margin-top: 50px;
}
.services-cart .card-header{
    background: #eee !important;
}
}
</style>
<form name="service_requestForm" id="service_requestForm">
    <div class="form-group mt-2">
        <div class="row">
            <div class="col-lg-4" ng-hide="booking.rooms.length==1">
                <label class=" col-form-label">Select Your Room<span class="text-danger"> *</span></label>
                <md-select  md-no-asterisk required aria-invalid="true" name="room_id" class="m-0" ng-model="service_request.room_id" placeholder="Select Room" ng-required="booking.rooms.length > 1">
                    <md-option  ng-repeat="room in booking.rooms" ng-value="room.id">[[room.room_title]]</md-option>
                </md-select>

                <div ng-messages="service_requestForm.room_id.$error" ng-if='service_requestForm.room_id.$touched || service_requestForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Room is required</div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs nav-tabs-bottom nav-justified mb-0">
        <li ng-repeat="department in departments" class="nav-item">
            <a ng-class="getDeptId(department.id)" ng-click="getDeptServices(department.id)" class="nav-link depatmentstabs " data-toggle="tab">
                <img class="img-thumbnail mx-auto" width="70" height="auto" src="[[department.IconPath]]" >
                <strong class="d-block">[[department.Department]]</strong>
                {{-- <i class="[[department.IconPath]] mr-2"></i>[[department.Department]] --}}
            </a>
        </li>
        <!-- <li class="nav-item">
            <a id="otherTabHeading" ng-click="showOther()" class="nav-link"> <i class="icon-hammer-wrench mr-2"></i> Other</a>
        </li>    -->
    </ul>

    <div class="tab-content card-body border-top-0 rounded-top-0 mb-0 row ">
        <div class="tab-pane fade active services-tab-pane show col-md-12" >
                <div class="row services-boxes-row">
                    <div ng-if="department_services.length < 1" class="no-service-div col-md-12">
                        <div class="card border-1 border-warning">
                            <span class="text-warning p-3">No Services Available! </span>
                        </div>
                    </div>
                    <div class="col-md-6" ng-repeat="service in department_services">
                        <div class="card servicesBox cursor-[[service.enable?'':'no']]">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 service-title-col border-bottom">
                                        <span class="title-service">
                                            <strong>[[service.Service]]</strong>
                                        </span>
                                        <span>
                                            <small class="badge badge-[[service.enable?'success':'danger']] mb-2" data-popup="popover" data-trigger="hover" data-html="true" data-content="[[service.msg]]" >
                                                [[service.enable?'Available':'Not Available']]
                                            </small>
                                        </span>
                                        <span>
                                            <i class="icon-info22" data-placement="right" data-popup="popover" title="Service Detail" data-trigger="hover" data-html="true"
                                                data-content="
                                                <ul class='tool-tip-list-item'>
                                                    <li><span>Charges : [[service.Charges | currency]]</span></li>
                                                    <li><span>Serving Time : [[service.ServingTime]]</span></li>
                                                </ul>" data-original-title="Popover title">
                                            </i>
                                        </span>
                                    </div>

                                    <div class="col-md-4 service-icon-col mt-1">
                                        <a class="text-teal mr-md-3 mb-3 mb-md-0">
                                            <img class="img-thumbnail img-fluid" src="[[service.IconPath]]" alt="[[service.Service]]">
                                        </a>
                                    </div>
                                    <div class="col-md-8 mt-3 service-count-col">
                                        <div ng-show="service.IsQuantitative=='1'" class="media-body text-center text-md-left inc_dec_btns">
                                            <div class="def-number-input number-input safari_only">
                                                <button ng-click="decrementTimes(service)" class="minus text-danger p-2 cursor-[[service.enable?'':'no']]" ng-disabled="!service.enable"></button>
                                                <input ng-required="" readonly ng-model="service.times" class="quantity form-control cursor-[[service.enable?'':'no']]" min="0" name="quantity" type="number" ng-disabled="!service.enable">
                                                <button ng-click="incrementTimes(service)" class="plus text-success p-2 cursor-[[service.enable?'':'no']]" ng-disabled="!service.enable"></button> 
                                            </div>
                                        </div>
                                        <div ng-hide="service.IsQuantitative=='1'">
                                            <button ng-click="addNotQuantitativeService(service)" class="btn btn-info p-2 float-right"> Add <i class="icon-plus3 ml-2"></i></button>
                                        </div>
                                    </div>
                                </div>     
                            </div>
                        </div>
                        
                    </div>
                </div>
        </div>

        <div id="servicesDetailRBox" class="col-md-4 services-cart" ng-show="service_request.services.length">
            <div class="card odr-card">
                <div class="card-header  border-bottom">
                    <h6 class="card-title font-weight-semibold">Services Details Cart</h6>
                </div>
                <div class="card-body p-0" ng-if="total_included > 0">
                    <div class="col-md-12">
                        <h6>Included Services</h6>
                    </div>
                    <div ng-repeat="service in service_request.services" ng-if="service.includes > 0" class="col-md-12 p-2 mt-2" style="background:#eee;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row m-0">
                                    <div class=" cart-service-icon-col">
                                        <img class="img-fluid img-thumbnail cart-service-icon" src="[[service.IconPath]]" alt="">
                                    </div>
                                    <div class=" cart-service-title-col">
                                        <div>[[service.Service]] <small>([[service.includes]]x)</small></div>
                                    </div>
                                    <div class=" cart-service-remove-btn">
                                        <i class="fa fa-close" ng-click="removeService(service)"></i>
                                    </div>
                                </div>
                                
                            </div>
                        </div>    
                    </div>
                </div>

                <div class="card-body p-0" ng-if="total_excluded > 0">
                    <div class="col-md-12">
                        <h6>Excluded Services</h6>
                    </div>
                    <div ng-repeat="service in service_request.services" ng-if="service.excludes > 0" class="col-md-12 p-2 mt-2" style="background:#eee;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row m-0">
                                    <div class=" cart-service-icon-col">
                                        <img class="img-fluid img-thumbnail cart-service-icon" src="[[service.IconPath]]" alt="">
                                    </div>
                                    <div class=" cart-service-title-col">
                                        <div>[[service.Service]] <small>([[service.excludes]]x)</small></div>
                                        <div>Charges: [[service.amount | currency]]</div>
                                    </div>
                                    <div class=" cart-service-remove-btn">
                                        <i class="fa fa-close" ng-click="removeService(service)"></i>
                                    </div>
                                </div>
                                
                            </div>
                        </div> 
                        {{-- <div class="row">
                            <div class="col-md-3">
                                <img class="img-fluid img-thumbnail cart-service-icon" src="[[service.IconPath]]" alt="">
                            </div>
                            <div class="col-md-7">
                                <span>[[service.Service]]</span><span class="c-qty"> ([[service.excludes]]x)</span>
                                <div>Charges: [[service.amount | currency]]</div>
                            </div>
                            <div class="col-md-2 text-right">
                                <i class="fa fa-close" ng-click="removeService(service)"></i>
                            </div>
                        </div>     --}}
                    </div>
                </div>

                <div class="card-footer border-top p-2">
                    <div class=" text-right" style="font-weight: 800;font-size: 14px;" >
                        Total: [[total_amount | currency]]
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
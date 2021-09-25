<div id="staffmember-form-section" class="card admin-form-section">
        <div class="card-body">
            @include('layouts.form_messages')
            <div class="row">
                <div class="col-md-2">
                    <!-- User card -->
                    <div class="card">
                        <div class="card-body bg-blue text-center card-img-top" style="background-image: url(global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid rounded-circle" src="[[ profile.picture!=null ? profile.picture : 'https://pwcenter.org/sites/default/files/default_images/default_profile.png' ]] " width="170" height="170" alt="">
                            </div>

                            <h6 class="font-weight-semibold mb-0">[[profile.first_name]] [[profile.last_name]]</h6>
                        </div>

                        <div class="card-body border-top-0 sidebar-light">

                            <ul class="nav nav-sidebar">
                                <li class="nav-item">
                                    <a href="#profile" class="nav-link show active" data-toggle="tab">
                                        <i class="icon-user"></i>
                                         My profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#change_password" class="nav-link" data-toggle="tab">
                                        <i class="icon-user-lock"></i>
                                        Change Password
                                    </a>
                                </li>

                                <li class="nav-item">
                                    {{-- <a href="#leave_request" class="btn btn-warning rounded-pill" data-toggle="tab">
                                        Leave Request
                                        <i class="icon-arrow-right8 ml-2"></i>
		                            </a> --}}
                                    <a href="#leave_requests" class="nav-link bg-warning" data-toggle="tab">
                                        <i class="icon-task"></i>
                                        Leave Requests
                                    </a>
                                </li>

                                
                                <li class="nav-item-divider"></li>
                                <li class="nav-item">
                                    <a href="login_advanced.html" class="nav-link" data-toggle="tab">
                                        <i class="icon-switch2 text-danger"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                            {{-- <button class="btn bg-indigo btn-block leave-request legitRipple" ng-click="createLeaveRequest()">Leave Request</button> --}}
                        </div>
                    </div>
                    <!-- /user card -->
                </div>
                <div class="col-md-10">
                    <div class="tab-content flex-1">
                        <div class="tab-pane fade show active" id="profile">
                            <div class="card basicInfo2">
                                <div class="card-body">
                                    <fieldset>
                                        <form ng-submit="updateProfile()">
                                            <div class="form-group row">
                                                {{-- <div class="col-md-12">
                                                    <label class="col-form-label font-w-500 txt-unln">1. Basic Information:</label>
                                                    <a class="list-icons-item" style="position: absolute; right: 20px;"><i class="icon-backspace2"></i></a>
                                                </div> --}}
                                                <div class="col-md-12">
                                                    <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light pt-3">
                                                        <i class="icon-user mx-2"></i>
                                                        Profile Image
                                                      </legend>
                                                    <div class="row my-2">
                                                        <label class="col-md-2 col-form-label">Profile Picture</label>
                                                        <div class="col-md-2">
                                                            <div class="wrapper prof-wrap">
                                                                <img id="preview" class="output_image" src="[[ profile.picture!=null ? profile.picture : 'https://pwcenter.org/sites/default/files/default_images/default_profile.png' ]]">
                                                                <div class="custom-file">
                                                                    <input name="logo" type="file" class="custom-file-input logo" id="logo" form="logo-form">
                                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="btns-div">
                                                                <button ng-show="profile.picture" name="staff" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload Image</button>
                                                            </div>
                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom  bg-light pt-3">
                                                        <i class="icon-grid mx-2"></i>
                                                        Basic Information
                                                    </legend>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="col-form-label">First Name</label>
                                                    <input required type="text" ng-model="profile.first_name" placeholder="First Name" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label">Last Name</label>
                                                    <input required type="text" ng-model="profile.last_name" placeholder="Last Name" class="form-control">
                                                </div>
                                            </div>
        
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label">Email</label>
                                                    <input required type="text" ng-model="profile.email" placeholder="Email" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <label class="col-form-label">Phone</label>
                                                            <input required type="text" ng-model="profile.phone_no" placeholder="Phone" class="form-control">
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
        
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label">DOB</label>
                                                    <input date ng-model="profile.dob" type="text" placeholder="Date of Birth" class="form-control pickadate-accessibility">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label">Gender:</label>
                                                    <md-select ng-model="profile.gender" class="m-0" required placeholder="Select your gender">
                                                        <md-option value="Male">Male</md-option>
                                                        <md-option value="Female">Female</md-option>
                                                        <md-option value="Transgender">Transgender</md-option>
                                                        <md-option value="Agender">Agender</md-option>
                                                        <md-option value="Bigender ">Bigender </md-option>
                                                    </md-select>
                                                </div>
        
                                            </div>
                                            <div class="text-right"> 
                                                <button type="submit" class="btn btn-primary legitRipple mt-2">Update Info <i class="icon-floppy-disk ml-2"></i></button>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="change_password">
                            <div class="card" id="change_password">
                                <div class="card-body">
                                    <fieldset>
                                        <form ng-submit="changePassword()">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light pt-3">
                                                        <i class="icon-user-lock mx-2"></i>
                                                        Update New Password
                                                    </legend>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="col-form-label">Old Password</label>
                                                    <input required type="password" ng-model="cred.old_password" placeholder="Old Password" class="form-control">
                                                </div>
                                                <div class="col-lg-12">
                                                    <label class="col-form-label">New Password</label>
                                                    <input required type="password" id="password" ng-model="cred.password" placeholder="New Password" class="form-control">
                                                </div>
                                                <div class="col-lg-12">
                                                    <label class="col-form-label">Confirm Password</label>
                                                    <input required type="password" id="password_confirmation" ng-model="cred.password_confirmation" placeholder="Confirm Password" class="form-control">
                                                    <span id='message'></span>
                                                </div>
                                            </div>
                                            <div class="text-right"> 
                                                <button type="submit" disabled class="btn btn-primary legitRipple">Change Password</button>
                                            </div>
                                        
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="leave_requests">
                            <!-- Basic view -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Basic view</h5>
                                </div>
                                
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-bottom flex-nowrap my-3">
                                        <li class="nav-item active show"><a href="#leave_request" class="nav-link active show" data-toggle="tab"><i class="icon-calendar2 mr-2 text-success"></i>Request for leave</a></li>
                                        <li class="nav-item"><a href="#my_leaves" class="nav-link my_leaves" data-toggle="tab"><i class="icon-calendar mr-2 text-warning"></i>My Leaves</a></li>
                                        <li class="nav-item"><a href="#tabular_leaves_view" class="nav-link tabular_leaves_view" data-toggle="tab"><i class="icon-table2 mr-2 text-warning"></i>Tabular View</a></li>
                                    </ul>
                                </div>
                            </div>
					        <!-- /basic view -->
                            <div id="leaveRequestFormSec" class="card">
                                <div class="card-header header-elements-inline border-bottom px-2">
                                    <h5 class="card-title">Leave Request Information</h5>
                                    <div class="header-elements">
                                        {{-- <div class="list-icons">
                                            <a ng-click="hideLeaveRequest()" class="list-icons-item" style="position: absolute; right: 20px;"><i class="icon-backspace2"></i></a>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content mt-3">

                                        <div class="tab-pane fade active show" id="leave_request">
                                            <fieldset>
                                                <form name="leaveForm" id="leaveForm">
                                                    <div class="form-group row">
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Leave Type</label>
                                                            <md-select md-no-asterisk name="leave_type" class="m-0" ng-model="leave.leave_type" placeholder="Select Leave Type" required>
                                                                <md-option ng-repeat="l in leave_types" ng-value="l">[[l]]</md-option>
                                                            </md-select>
                                                            <div ng-messages="leaveForm.leave_type.$error" ng-if='leaveForm.leave_type.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                                                <div class="text-danger" ng-message="required">Leave Type is required</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">Start Date</label>
                
                                                            <div class="input-group">
                                                                <span class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                                </span>
                                                                <input required name="LeaveRequestFrom" type="text" date placeholder="MM/DD/YYYY" id="LeaveRequestFrom"  ng-model="leave.LeaveRequestFrom" class="form-control pickadate">
                                                                <input type="hidden" id="hdnLeaveRequestFrom">
                                                            </div>
                        
                                                            <div ng-messages="leaveForm.LeaveRequestFrom.$error" ng-if='leaveForm.LeaveRequestFrom.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                                                <div class="text-danger" ng-message="required"> Start Date is required</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="col-form-label">End Date</label>
                
                                                            <div class="input-group">
                                                                <span class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                                </span>
                                                                <input required name="LeaveRequestTo" type="text" date placeholder="MM/DD/YYYY" id="LeaveRequestTo"  ng-model="leave.LeaveRequestTo" class="form-control pickadate">
                                                                <input type="hidden" id="hdnLeaveRequestTo">
                                                            </div>
                        
                                                            <div ng-messages="leaveForm.LeaveRequestTo.$error" ng-if='leaveForm.LeaveRequestTo.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                                                <div class="text-danger" ng-message="required"> End Date is required</div>
                                                            </div>
                                                        </div>
        
                                                        <div class="col-md-4 mt-3">
                                                            <label class="col-form-label">Reason</label>
                                                                <textarea class="form-control" ng-model="leave.reason" name="reason" id="" placeholder="Kindly define a reason"></textarea>
                                                        </div>
                                                    </div>
                
                                                    <div class="text-right mt-3"> 
                                                        <button ng-click="saveLeaveRequest()" class="btn btn-primary legitRipple">Send<i class="icon-paperplane ml-2"></i></button>
                                                    </div>
                                                </form>
                                            </fieldset>
                                        </div>
                                        <div class="tab-pane fade" id="my_leaves">
                                            <div class="fullcalendar-event-colors"></div>
                                         </div>
                                        <div class="tab-pane fade" id="tabular_leaves_view">
                                           <div class="leave-table">
                                               <table class="table table-bordered table-striped table-hover">
                                                   <thead>
                                                       <tr>
                                                           <th>Type</th>
                                                           <th>From</th>
                                                           <th>To</th>
                                                           <th>Reason</th>
                                                           <th>Status</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       <tr ng-repeat="leave in leaves">
                                                           <td>[[leave.type]]</td>
                                                           <td>[[leave.LeaveRequestFrom |date]]</td>
                                                           <td>[[leave.LeaveRequestTo |date]]</td>
                                                           <td>[[leave.reason]]</td>
                                                           <td><span ng-class="getLeaveStatus(leave.status)" class="badge">[[leave.status]]</span></td>
                                                       </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="basicInfoSec" class="card basicInfo1" style="display: none;">
                        <div class="card-header header-elements-inline border-bottom">
                            <h5 class="card-title">Basic Information</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <span class="badge badge-info cursor-pointer"> <i class="icon-pencil mx-1" data-popup="popover" data-trigger="hover" data-html="true" data-content="Edit Info"></i></span>
                                    <span ng-click="createLeaveRequest()" class="badge badge-info cursor-pointer"> <i class="icon-calendar2 mx-1" data-popup="popover" data-trigger="hover" data-html="true" data-content="Request Leave"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <a href="#" class="d-inline-block mb-3">
                                <img  src="[[ profile.picture!=null ? profile.picture : 'https://pwcenter.org/sites/default/files/default_images/default_profile.png' ]] " class="rounded-round" width="150" height="150" alt="">
                            </a>
                            <div class="mb-3">
                                <h6 class="font-weight-semibold mb-0 mt-1"> [[profile.first_name]] [[profile.last_name]]</h6>
                                <span class="d-block text-muted">[[profile.type]]</span>
                                <span class="d-block text-muted">[[profile.email]]</span>
                                <span class="d-block text-muted">[[profile.phone_no]]</span>
                                <span class="d-block text-muted">[[profile.dob|date:'M/d/y']]</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div id="leaveRequestFormSec" class="card" style="display:none">
                        <div class="card-header header-elements-inline border-bottom px-2">
                            <h5 class="card-title">Leave Request Information</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a ng-click="hideLeaveRequest()" class="list-icons-item" style="position: absolute; right: 20px;"><i class="icon-backspace2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
                                <li class="nav-item active show"><a href="#leave_request" class="nav-link active show" data-toggle="tab"><i class="icon-calendar2 mr-2 text-success"></i>Request for leave</a></li>
                                <li class="nav-item"><a href="#my_leaves" class="nav-link my_leaves" data-toggle="tab"><i class="icon-calendar mr-2 text-warning"></i>My Leaves</a></li>
                            </ul>
                            <div class="tab-content mt-3">
                                <div class="tab-pane fade active show" id="leave_request">
                                    <fieldset>
                                        <form name="leaveForm" id="leaveForm">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label class="col-form-label">Leave Type</label>
                                                    <md-select md-no-asterisk name="leave_type" class="m-0" ng-model="leave.leave_type" placeholder="Select Leave Type" required>
                                                        <md-option ng-repeat="l in leave_types" ng-value="l">[[l]]</md-option>
                                                    </md-select>
                                                    <div ng-messages="leaveForm.leave_type.$error" ng-if='leaveForm.leave_type.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                                        <div class="text-danger" ng-message="required">Leave Type is required</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="col-form-label">Start Date</label>
        
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                        </span>
                                                        <input required name="LeaveRequestFrom" type="text" date placeholder="MM/DD/YYYY" id="LeaveRequestFrom"  ng-model="leave.LeaveRequestFrom" class="form-control pickadate">
                                                        <input type="hidden" id="hdnLeaveRequestFrom">
                                                    </div>
                
                                                    <div ng-messages="leaveForm.LeaveRequestFrom.$error" ng-if='leaveForm.LeaveRequestFrom.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                                        <div class="text-danger" ng-message="required"> Start Date is required</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="col-form-label">End Date</label>
        
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                        </span>
                                                        <input required name="LeaveRequestTo" type="text" date placeholder="MM/DD/YYYY" id="LeaveRequestTo"  ng-model="leave.LeaveRequestTo" class="form-control pickadate">
                                                        <input type="hidden" id="hdnLeaveRequestTo">
                                                    </div>
                
                                                    <div ng-messages="leaveForm.LeaveRequestTo.$error" ng-if='leaveForm.LeaveRequestTo.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                                        <div class="text-danger" ng-message="required"> End Date is required</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mt-3">
                                                    <label class="col-form-label">Reason</label>
                                                        <textarea class="form-control" ng-model="leave.reason" name="reason" id="" placeholder="Kindly define a reason"></textarea>
                                                </div>
                                            </div>
        
                                            <div class="text-right mt-3"> 
                                                <button ng-click="saveLeaveRequest()" class="btn btn-primary legitRipple">Send<i class="icon-paperplane ml-2"></i></button>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>

                                <div class="tab-pane fade" id="my_leaves">
                                   <div class="leave-table">
                                       <table class="table table-bordered table-striped table-hover">
                                           <thead>
                                               <tr>
                                                   <th>Type</th>
                                                   <th>From</th>
                                                   <th>To</th>
                                                   <th>Reason</th>
                                                   <th>Status</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               <tr ng-repeat="leave in leaves">
                                                   <td>[[leave.type]]</td>
                                                   <td>[[leave.LeaveRequestFrom |date]]</td>
                                                   <td>[[leave.LeaveRequestTo |date]]</td>
                                                   <td>[[leave.reason]]</td>
                                                   <td><span ng-class="getLeaveStatus(leave.status)" class="badge">[[leave.status]]</span></td>
                                               </tr>
                                           </tbody>
                                       </table>
                                   </div>
                                </div>
                            </div>
                            
                        </div>
                    </div> --}}

                    

                    

                </div>
                {{-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <fieldset>
                                <form ng-submit="changePassword()">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label class="col-form-label font-w-500 txt-unln">2. Change Password:</label>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="col-form-label">Old Password</label>
                                            <input required type="password" ng-model="cred.old_password" placeholder="Old Password" class="form-control">
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="col-form-label">New Password</label>
                                            <input required type="password" id="password" ng-model="cred.password" placeholder="New Password" class="form-control">
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="col-form-label">Confirm Password</label>
                                            <input required type="password" id="password_confirmation" ng-model="cred.password_confirmation" placeholder="Confirm Password" class="form-control">
                                            <span id='message'></span>
                                        </div>
                                    </div>
                                    <div class="text-right"> 
                                        <button type="submit" disabled class="btn btn-primary legitRipple">Change Password</button>
                                    </div>
                                
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div> --}}
            </div>

    
    <form action="saveProfilePicture" method="post" enctype="multipart/form-data" id="logo-form" onsubmit="return false;"></form>
</div>

<script>
    $('#password, #password_confirmation').on('keyup', function () {
        if ($('#password').val() == $('#password_confirmation').val()) {
            $('#password_confirmation').removeClass('invalid-box');
            $('#password_confirmation').addClass('valid-box');
            $('.legitRipple').prop('disabled', false);

        } else {
            $('#password_confirmation').addClass('invalid-box');
            $('#password_confirmation').removeClass('valid-box');
            $('.legitRipple').prop('disabled', true);

        }
    });
</script>

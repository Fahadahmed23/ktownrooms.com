
<style>
    .mb-3 .col-3 {
      border-bottom: 1px solid#ddd;
      border-right: 1px solid #ddd;
      padding: 15px 25px;
  }
  .facility-icon{
    border-radius: 100%;
  }
  .list-item span {
    width: 25%;
    float: left;
}
.facility-icon-list {
    padding: 0;
    list-style: none;
    max-height: 180px;
    overflow: auto;
}
.list-item {
    margin: 5px 0;
}

  </style>
<div id="addNewRoomCategory" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[roomcategory.id?'Update':'Add New']] Room Category</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        @include('layouts.form_messages')
        <form name="roomcategoryForm" id="roomcategoryForm" class="card-body">
          <div class="row">
            <div class="col-md-6">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-diff-modified mr-2"></i>
                  Basic information
                </legend>
                <div class="collapse show bg-light p-2 mb-2">
                    <div class="form-group row">
                      <div class="col-md-4">        
                        <label class=" col-form-label">Name <span  class="text-danger">*</span> </label>
                        <input  maxlength="50" ng-required="true" name="RoomCategory" id="RoomCategory" type="text" class="form-control px-2 alphabets" ng-model="roomcategory.RoomCategory" placeholder="Premium">
                        
                        <div ng-messages="roomcategoryForm.RoomCategory.$error" ng-if='roomcategoryForm.RoomCategory.$touched || roomcategoryForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Category Name is required</div>
                        </div>
                      </div>

                      <div class="col-md-4">        
                        <label class=" col-form-label">Allowed Occupants <span class="text-danger">*</span></label>
                        <input maxlength="2" ng-required="true" id="allowedoccupants" name="AllowedOccupants" type="text" class="form-control px-2 num2" ng-model="roomcategory.AllowedOccupants" placeholder="2"  >
                        
                        <div ng-messages="roomcategoryForm.AllowedOccupants.$error" ng-if='roomcategoryForm.AllowedOccupants.$touched || roomcategoryForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Allowed Occupants is required</div>
                        </div>
                      
                      </div>

                      <div class="col-md-4">        
                          <label class=" col-form-label">Max Allowed Occupants <span  class="text-danger">*</span></label>
                          <input maxlength="2" ng-required="true" id="maxallowedoccupants" name="MaxAllowedOccupants" type="text" class="form-control px-2 num2" ng-model="roomcategory.MaxAllowedOccupants" placeholder="3"  >
                          
                          <div ng-messages="roomcategoryForm.MaxAllowedOccupants.$error" ng-if='roomcategoryForm.MaxAllowedOccupants.$touched || roomcategoryForm.$submitted' ng-cloak style="color:#e9322d;">
                              <div class="text-danger" ng-message="required">Max Allowed Occupants is required</div>
                          </div>
                      
                      </div>
                    </div>
                </div>

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-primitive-dot mr-2"></i>
                  Other information
                </legend>
                <div class="collapse show bg-light p-2 mb-2">
                    <div class="form-group row">
                      <div class="col-md-6">        
                        <label class=" col-form-label">Badge Color <span  class="text-danger">*</span> </label>
                        <div class="color-picker">
                          <input type="color" id="html5colorpicker" onchange="clickColor(0, -1, -1, 5)" ng-value="#45818e" ng-model="roomcategory.Color" style="width:85%;">
                        </div>
                      </div>


                    </div>
                </div>
            </div>

            <div class="col-md-6">
              <legend class="font-weight-semibold text-uppercase font-size-sm">
                <i class="icon-puzzle4 mr-2"></i>
                Room Facilities
              </legend>
              <div class="collapse show bg-light p-2 mb-2">
                  <ul class="row facility-icon-list">
                    <li ng-repeat="facility in facilities" class="list-item col-md-6" >
                      <span><img class="img-fluid img-thumbnail facility-icon mr-2" src="[[facility.Image]]" width="50" height="50" alt=""></span>
                      <span class="mt-2"><md-checkbox style="display:block" ng-value="facility" ng-click="checkFacility(facility)" ng-checked="roomcategory.facilities.indexOf(facility.id) > -1">
                        [[facility.Facility]]
                        </md-checkbox>
                      </span>
                    </li>
                  </ul>
                  
              </div>
            </div>
          </div>

           
            <div class="text-right">
			<button type="button" ng-click="saveRoomCategory()" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[roomcategory.id?'Update':'Save']]</button>
			</div>
        </form>
</div>
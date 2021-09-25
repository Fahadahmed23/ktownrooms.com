<div id="addNewCategoryFacility" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[categoryfacility.id?'Update':'Add New']] CategoryFacility</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        @include('layouts.form_messages')
        <form id="categoryfacilityForm" class="card-body" name="categoryfacilityForm" method="POST">
            <div class="form-group row">               
                <div class="col-md-3"> 
                 <label class="col-lg-6 col-form-label">Room Category</label>
             <select name="roomcategory_id" id="roomcategory_id"  ng-model="categoryfacility.roomcategory_id" class="form-control select-icons">  
                  <option value="">Select your Room Category</option>  
                  <option ng-repeat="roomcategory in roomcategories  " ng-value="roomcategory.id">  
                     [[roomcategory.RoomCategory]]
                  </option>  
             </select> 
                </div>
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Facility</label>
                 <select name="facility_id[]" id="facility_id" ng-model="categoryfacility.facility_id" class="form-control multiselect-select-all" multiple="multiple" data-fouc>
                  <option ng-repeat="facility in facilities" ng-value="facility.id">  
                     [[facility.Facility]]
                  </option>  
             </select> 
             
               </div>
            </div>
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveCategoryFacility()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[categoryfacility.id?'Update':'Save']]</button>
			</div>
        </form>
</div>
    <!-- <script src="{{asset('global_assets/js/demo_pages/form_multiselect.js')}}"></script> -->

    <script>
        $(window).bind("load", function() {
            $('.multiselect-select-all').multiselect({
                includeSelectAllOption: true
            });
        });
        </script>
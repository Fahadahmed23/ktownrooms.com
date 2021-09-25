<div id="addNewHotelContact" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[hotelcontact.id?'Update':'Add New']] HotelContact</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        <!-- <div id="form-errors" class="alert alert-danger" style="display:none">
            <ul ng-repeat="error in errors">
                <li>[[error]]</li>
            </ul>
        </div> -->
        @include('layouts.form_messages')
        <form id="hotelcontactForm" class="card-body" name="hotelcontactForm" method="POST">
            <div class="form-group row">
                <div class="col-md-3">        
                               
                 <label class="col-lg-6 col-form-label">Hotel</label>
                <select name="hotel_id" id="hotel_id"  ng-model="hotelcontact.hotel_id" class="form-control">  
                  <option value="">Select your Hotel</option>  
                  <option ng-repeat="hotel in hotels  " ng-value="hotel.id">  
                     [[hotel.HotelName]]
                  </option>  
                 </select>     
                
                
                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Contact Type</label>
                                
                 <select name="contact_type_id" id="contact_type_id"  ng-model="hotelcontact.contact_type_id" class="form-control">  
                  <option value="">Select your Contact Type</option>  
                  <option ng-repeat="contacttype in contacttypes  " ng-value="contacttype.id">  
                     [[contacttype.ContactType]]
                  </option>  
                 </select>   
               
                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Value</label>
                 <input id="Value" type="text" class="form-control px-2" ng-model="hotelcontact.Value" placeholder="Enter Value"  >
                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Contact Person</label>
                 <input id="ContactPerson" type="text" class="form-control px-2" ng-model="hotelcontact.ContactPerson" placeholder="Enter Name"  >
                </div>
               
            </div>
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveHotelContact()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[hotelcontact.id?'Update':'Save']]</button>
			</div>
        </form>
</div>
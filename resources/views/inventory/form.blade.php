
<div id="addNewInventory" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[room.id?'Update':'Add New']] Inventory</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        @include('layouts.form_messages')
        <form name="inventoryForm" id="inventoryForm" class="card-body" enctype="multipart/form-data" >

            <div class="col-lg-6">
              <div class="row">
              <div class="col-md-12">
                <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ">
                  <i class="icon-city mr-2"></i>
                  Inventory Thumbnail
                </legend>
              </div>
                
                {{-- <label class="col-lg-3 col-form-label">Room Picture</label> --}}
                <div class="col-lg-3">
                  <div class="wrapper prof-wrap">
                    <img id="preview" class="output_image" ng-src="[[ inventory.Image!=null ? inventory.Image : 'https://mtbcycletours.com/wp-content/uploads/2019/02/bedroom-512.png' ]]" style="padding:5px;">
                    <div class="custom-file">
                      <input name="logo" type="file" class="custom-file-input logo" form="logo-form">
                      <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="btns-div">
                    <button ng-hide="inventory.Image" name="inventory" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                    <button ng-show="inventory.Image" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('inventory')"><i class="icon-cancel-circle2"></i> Remove</button>
                  </div>

                </div>

              </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-city mr-2"></i>
                    Inventory information
                  </legend>
                </div>

                <div class="col-md-3"> 
                 <label class="col-lg-6 col-form-label">Title<span class="text-danger">*</span></label>
                  
                 <input name="Title" maxlength="50"  type="text" class="form-control px-2 alpha_numeric " ng-model="inventory.Title" placeholder="Tea Bags/Tissues/Towels..." required>

                  <div ng-messages="inventoryForm.Title.$error" ng-if='inventoryForm.Title.$touched || inventoryForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Title is required</div>
                  </div>
                </div> 

                <div ng-hide="!is_admin" class="col-md-3"> 
                  <label class="col-lg-6 col-form-label">Hotel</label>
                  <md-select name="HotelId" class="m-0" ng-model="inventory.hotel_id" placeholder="Select a Hotel" required>
                    <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                  </md-select>
                  <div ng-messages="inventoryForm.HotelId.$error" ng-if='inventoryForm.HotelId.$touched || inventoryForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Hotel is required</div>
                  </div>
                </div> 

                
                         
                {{-- <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Quantity <span class="text-danger">*</span></label>
                 <input name="Quantity"  type="text" class="form-control px-2" number data-type="number_format" ng-model="inventory.Quantity" placeholder="10" required>
                 
                 <div ng-messages="inventoryForm.Quantity.$error" ng-if='inventoryForm.Quantity.$touched || inventoryForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Quantity is required</div>
                 </div>
                
                </div> --}}

                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Low Stock Alert <span class="text-danger">*</span></label>
                  <input name="LowStockAlert"  type="text" class="form-control px-2" number data-type="number_format" ng-model="inventory.LowStockAlert" placeholder="Set alert when quantity is less than your given number" required>
                  
                  <div ng-messages="inventoryForm.LowStockAlert.$error" ng-if='inventoryForm.LowStockAlert.$touched || inventoryForm.$submitted' ng-cloak style="color:#e9322d;">
                   <div class="text-danger" ng-message="required">Low Stock Alert is required</div>
                  </div>
                 
                 </div>

                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Rate <span class="text-danger">*</span></label>
                  <input name="Rate" type="text" class="form-control px-2" currency data-type="currency" ng-model="inventory.Rate" placeholder="$50" required>
                  
                  <div ng-messages="inventoryForm.Rate.$error" ng-if='inventoryForm.Rate.$touched || inventoryForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Rate is required</div>
                   </div>
                
                </div>

             

                <div class="col-md-3">        
                  <label class="col-lg-6 col-form-label">Description<span class="text-danger">*</span></label>
                  {{-- <input name="FullName" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="inventory.FullName" placeholder="Asad Ali" required> --}}
                  <textarea name="Description" ng-model="inventory.Description" class="form-control px-2" rows="1" placeholder="Inventory item complete detail" required></textarea>
                  
                  <div ng-messages="inventoryForm.Description.$error" ng-if='inventoryForm.Description.$touched || inventoryForm.$submitted' ng-cloak style="color:#e9322d;">
                   <div class="text-danger" ng-message="required">Description is required</div>
                  </div>
                 </div>  

                <div class="col-md-3 ">
                  <label class="col-lg-6 col-form-label">Status </label>
                  <md-switch ng-model="inventory.Status" ng-true-value="1" ng-false-value="0" style="display:block" >
                  <span class="">Active</span>
                </md-switch>
                </div>

                
            </div>
            <div class="text-right mt-2">
              <button  type="button" ng-click="saveInventory()" id="btn-save" class="btn btn-sm bg-success">[[inventory.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>

        
</div>


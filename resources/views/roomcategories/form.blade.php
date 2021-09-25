<div id="addNewRoomCategory" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[roomcategory.id?'Update':'Add New']] RoomCategory</h5>
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
        <form id="roomcategoryForm" class="card-body" name="roomcategoryForm" method="POST">
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Name</label>
                 <input id="roomcategoryName" type="text" class="form-control px-2" ng-model="roomcategory.RoomCategory" placeholder="Enter Room Category"  pattern="^[A-Z a-z]*$" ng-pattern-restrict>
                </div>
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Allowed Occupants</label>
                 <input id="allowedoccupants" type="text" class="form-control px-2" ng-model="roomcategory.AllowedOccupants" placeholder="Enter No. of occupants"  pattern="^[1-9]*$" ng-pattern-restrict>
                </div>
            </div>
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveRoomCategory()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[roomcategory.id?'Update':'Save']]</button>
			</div>
        </form>
</div>
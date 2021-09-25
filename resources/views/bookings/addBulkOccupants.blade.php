<div id="addBulkOccupants" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Bulk Occupant</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id="bulkocupantform" name="bulk_occupant_form">
				<div class="modal-body">
					<fieldset>
						<div class="form-group row">		                         
                            <div class="col-lg-4">
                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="occupantFirstName" required  ng-model="bookOccupant.bulk_FirstName" type="text" placeholder="Asad Ali" class="form-control alphabets" maxlength="10">
                            </div>
                            <div class="col-lg-4">   
                                <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="occupantLastName" required ng-model="bookOccupant.bulk_LastName" type="text" placeholder="Khan" class="form-control alphabets" maxlength="10">
                            </div>
                            <div class="col-lg-4">
                                <label class="col-form-label">CNIC # <span class="text-danger">*</span></label>
                                <div class="form-group form-group-feedback form-group-feedback-right">
                                    <input aria-invalid="true" name="occupantCNIC" required  ng-model="bookOccupant.bulk_CNIC" type="text" placeholder="42101-099099-152" class="form-control cnic" pattern="[\d]{5}-[\d]{7}-[\d]{1}">
                                </div>
                            </div>
                        </div>
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="showbulkOccupants()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i>Add</button>
                </div>
            </form>

		</div>
	</div>
</div>
{{-- <script>
        $( document ).ready(function() {
            $("#addBulkOccupants").modal();
        });
</script> --}}

<div id="clientModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Upload Corporate Clients Sheet</h5>
				<button type="button" class="close" ng-click="hideImportClientModal()">&times;</button>
			</div>
            <form name="clientsheet_form" id="clientsheet_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 excel-sheet-input">
                            <input name="co_client_sheet" type="file" class="form-control p-0 excel-sheet" ng-model="co_client_sheet" required>
                            {{-- <div ng-messages="clientsheet_form.co_client_sheet.$error" ng-if="clientsheet_form.co_client_sheet.$touched || clientsheet_form.$submitted">
                                <div class="text-danger" ng-message="required">Please choose client sheet to upload!</div>
                            </div> --}}
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <small><button type="button" ng-click="uploadClient()" class="btn btn-success btn-sm mt-3 excel-upload">Upload  <i class="icon-redo2 ml-1"></i></button></small>
                        </div>
                    </div>
                </div>  
            </form>    
		</div>
	</div>
</div>
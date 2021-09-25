<style>
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }

/* .card.servicesBox {
    min-height: 210px;
} */
.cursor-no {
    cursor: no-drop !important;
}
.c_table-tab{display: none;}
</style>

<div id="addNewServiceRequest" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close py-0 px-1" ng-click="hideServiceModal()">&times;</button>
			</div>

            <div class="modal-body pt-0">
                @include('housekeeping.services_form')
                {{-- @include('housekeeping') --}}
            </div>
            <div class="modal-footer border-top pt-3">
                <div class="text-right">
                    <button type="button" ng-click="checkAvailedServices()" class="btn btn-sm bg-warning"><i class="icon-stack-check mr-1"></i>Availed Services</button>
                </div>
                <div class="text-right">
                    <button ng-disabled="!service_request.services || service_request.services.length == 0" type="button" ng-click="saveRequest()" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i>Launch Request</button>
                </div>
            </div>
		</div>
	</div>
</div>
@include('housekeeping.services_complains')
    

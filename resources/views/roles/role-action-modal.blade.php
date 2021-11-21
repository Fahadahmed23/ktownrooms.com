<div id="roleAction" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-xs">
		<div class="modal-content">
			<!-- <div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div> -->
			{{-- <form ng-submit="addAddress(addressObj.id)"> --}}

				<div class="modal-body">

					<fieldset>
						<div class="list-icons row">
							<a class="current-div1 list-icons-item p-2" ng-click="viewRoleForm(role.id)">
								<span><i class="icon-eye8"></i></span>
								View Role
							</a>
							@permission('can-add-role')
							<a class="current-div1 list-icons-item p-2" ng-click="showRoleForm(role.id)">
								<span><i class="icon-pencil6"></i></span>
								Edit Role
							</a>
							@endpermission
							@permission('can-delete-role')
							<a class="current-div1 list-icons-item p-2" ng-click="removeRole(role.id)">
								<span><i class="icon-trash"></i></span>
								Delete Role
							</a>
							@endpermission

						</div>




						

					</fieldset>
				</div>


		{{-- </div> --}}
	</div>
</div>
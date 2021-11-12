<div ng-repeat="department in departments" class="kt-kitchen kt d-flex col-md-4 text-center" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
    <div ng-click="createServiceRequest(department.id)" class="card [[department.bg_color]] text-white flex-fill" style="cursor: pointer; background-color:[[department.bg_color]];">
    <div class="card-body text-center">
        <a  href="javascript:void(0)" class="text-white">
        {{-- <i class="[[department.IconPath]] fa-2x border-3 rounded-round p-3 mb-3 mt-1"></i> --}}
        <img class="img-thumbnail" width="50" height="auto" src="[[department.IconPath]]" alt="[[department.Department]]">
        <h5 class="card-title">[[department.Department]]</h5>
        </a>
    </div>
   </div>
</div>

{{-- <div class="kt-kitchen kt col-md-4 text-center" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
    <div ng-click="createOtherRequest()" class="card bg-warning-400 text-white" style="cursor: pointer;">
    <div class="card-body text-center">
        <a  href="javascript:void(0)" class="text-white">
        <i class="icon-hammer-wrench fa-2x border-3 rounded-round p-3 mb-3 mt-1"></i>
        <h5 class="card-title">Other</h5>
        </a>
    </div>
   </div>
</div> --}}
<div class="card card-body bg-indigo text-white"
    style="background-image: url(../../../../global_assets/images/backgrounds/panel_bg.png);">
    <div class="media d-inline">
    <div class="row">
        <div class="col-md-6">
                <div class="mr-3 align-self-center">
                    <h6 class="media-title font-weight-semibold">[[records.greeting_message]]</h6>
                    <span class="opacity-75" ng-bind-html="[[records.greeting_description]]"></span>
                </div>
        </div>

        <div class="col-md-6 text-right" ng-hide="hotels.length == 1">

                <div class="list-icons ml-auto">
                    <div class="dropdown position-static">
                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="icon-filter3"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(157px, 48px, 0px);">
                            <a ng-repeat="h in hotels"  ng-model="h.id" ng-click="getRecords(h.id)" class="dropdown-item cstClassH [[h.is_active ? 'active' : '']]">[[h.HotelName]]</a>
                           
                        </div>
                    </div>
                </div>

         
    </div>
    </div>
        

        {{-- <div class="media-body text-right">
                        <h6 class="media-title font-weight-semibold">[[records.greeting_message]]</h6>
                        <span class="opacity-75">[[records.greeting_description]]</span>
                    </div> --}}
    </div>
</div>
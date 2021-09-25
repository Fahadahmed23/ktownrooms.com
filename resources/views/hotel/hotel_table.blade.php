<style>
    .table-responsive {
        height: 100%;
        min-height: 600px;
    }
</style>
<div id="hotels-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"> Hotels
                <span><a href="#" class="" ng-click="showFilter()">
                    <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
               </a></span>
            </h5>
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-sm btn-primary " ng-click="addHotel()"><i class="mr-1 icon-plus22"></i>New Hotel</button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="init()"></a>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Total Rooms </th>
                        <th>Total Booking </th>
                        <th>Total Revenue </th>
                        <th>Ktown Commission % </th>
                        <th>Actions</th>
                        <th class="d-none"></th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="hotel in hotels | filter:{HotelName:searchName, CityName:searchCity}" class="unread">
                        <td>[[hotel.HotelName]]</td>
                        <td>[[hotel.city.CityName]]</td>
                        <td>[[hotel.Address]]</td>
                        <td>[[hotel.RoomCount]]</td>
                        <td>[[hotel.BookingCount]]</td>
                        <td>[[hotel.BookingRevenueSum | currency]]</td>
                        <td>[[ hotel.KtownCommission ]]</td>
                        <td>
                            <div class="align-self-left">
                                <div class="list-icons list-icons-extended">
                                    
                                    @permission('can-edit-hotel')
                                    <a href="javascript:void(0)" ng-click="editHotel(hotel)" class="list-icons-item edit-sec"><i class="icon-pencil5"></i></a>
                                    @endpermission

                                    @permission('can-delete-room')
                                    <a ng-click="deleteHotel(hotel)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                                    @endpermission
                                </div>
                            </div>
                        </td>
                        <td class="d-none"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
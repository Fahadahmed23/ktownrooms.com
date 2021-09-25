<div id="roomTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Hotel</th>
                <th>Room Image</th>
                <th>Room Title</th>
                <th>Room Type</th>
                <th>Room Category</th>
                <th>Room Number</th>
                <th>Floor No</th>
                <th>Room Charges</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="room in rooms| filter : {HotelName:searchHotel, room_title:searchRoom , RoomType:searchType, RoomCategory:searchCategory}" class="unread">     
                <td>[[room.hotel.HotelName]]</td>
                <td><img ng-if="room.thumbnail" width="50px" height="auto" ng-src="[[room.thumbnail]]"></td>
                <td>[[room.room_title]]</td>    
                <td>[[room.room_type.RoomType]]</td>
                <td>[[room.category.RoomCategory]]</td>
                <td>[[room.RoomNumber]]</td>
                <td>[[room.FloorNo]]</td>
                <td>[[room.RoomCharges | currency]]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            @permission('can-edit-room')
                            <a id="edit-room" ng-click="editRoom(room)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            @endpermission

                            @permission('can-delete-room')
                            <a id="delete-room" ng-click="deleteRoom(room)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                            @endpermission
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
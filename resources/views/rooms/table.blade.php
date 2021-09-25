<div class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Room Id #</th>
                <th>Hotel</th>
                <th>Room Title</th>
                <th>Room Type</th>
                <th>Room Category</th>
                <th>Room Number</th>
                <th>Floor No</th>
                <th>Room Charges</th>
                <th>Tax Rate</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="room in rooms" class="unread">
                <td>[[room.id]]</td>
                <td>[[room.hotels.HotelName]]</td>
                <td>[[room.room_title]]</td>
                <td>[[room.room_types.RoomType]]</td>
                <td>[[room.room_categories.RoomCategory]]</td>
                <td>[[room.RoomNumber]]</td>
                <td>[[room.FloorNo]]</td>
                <td>[[room.RoomCharges]]</td>
                <td>[[room.tax_rates.Tax]]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-room" ng-click="editRoom(room)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-room" ng-click="deleteRoom(room)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
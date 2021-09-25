<div  class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">RoomCategory Id #</th>
                <th>Room Category </th>
                <th>Allowed Occupants </th>
                <th>Max Allowed Occupants </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="RoomCategory in roomcategories |filter : {RoomCategory:searchCategory}" class="unread">
                <td style="display:none;">[[RoomCategory.id]]</td>
                <td><span class="letter-icon-title text-default badge  text-white" style="background-color:[[RoomCategory.Color]];">[[RoomCategory.RoomCategory]]</span></td>
                <td><span class="letter-icon-title text-default">[[RoomCategory.AllowedOccupants]]</span></td>
                <td><span class="letter-icon-title text-default ">[[RoomCategory.MaxAllowedOccupants]]</span></td>
                
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-RoomCategory" ng-click="editRoomCategory(RoomCategory)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-RoomCategory" ng-click="deleteRoomCategory(RoomCategory)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

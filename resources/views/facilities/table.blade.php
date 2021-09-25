<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Facility Id #</th>
                <th>Facility</th>
                <th>Icons</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="facility in facilities | filter : {id:searchID,Facility:searchName}" class="unread">
                <td style="display:none;">[[facility.id]]</td>
                <td><span class="letter-icon-title text-default">[[facility.Facility]]</span></td>
                {{-- <td><span class="letter-icon-title text-default"><i width="30px" height="30px" class="fa [[facility.IconPath]] mr-2 fa-2x"></i></span></td> --}}
                <td><img ng-if="facility.Image" width="30px" height="auto" ng-src="[[facility.Image]]"></td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-facility" ng-click="editFacility(facility)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-facility" ng-click="deleteFacility(facility)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
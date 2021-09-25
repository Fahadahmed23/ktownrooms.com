<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Hotel Id #</th>
                <th>Company</th>
                <th>City</th>
                <th>Address</th>
                <th>Zip Code</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="hotel in hotels | filter : filterSearchText" class="unread">
                <td style="display:none;">[[hotel.id]]</td>
                <td><span class="letter-icon-title text-default">[[hotel.CompanyName]]</span></td>
                <td><span class="letter-icon-title text-default">[[hotel.CityName]]</span></td>
                <td><span class="letter-icon-title text-default">[[hotel.Address]]</span></td>
                <td><span class="letter-icon-title text-default">[[hotel.ZipCode]]</span></td>
                <td><span class="letter-icon-title text-default">[[hotel.Longitude]]</span></td>
                <td><span class="letter-icon-title text-default">[[hotel.Latitude]]</span></td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-hotel" ng-click="editHotel(hotel)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-hotel" ng-click="deleteHotel(hotel)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
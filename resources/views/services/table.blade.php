<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                
                <th>Service</th>
                <th>Hotel</th>
                <th>Service Type</th>
                <th>Department</th>
                <th>Charges</th>
                {{-- <th>Serving Time</th> --}}
                {{-- <th>Is Show Delay Alert</th>
                <th>Is Quantitative</th>
                <th>Is Inventory</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="service in services | filter: {id:searchID , Service:searchName, Department:searchDeparment, ServiceType:searchType }" class="unread">
                <td><img class="img-thumbnail mr-2" ng-if="service.IconPath" width="30px" height="auto" ng-src="[[service.IconPath]]"> [[service.Service]]</td>
                <td>[[service.HotelName]]</td>
                <td>[[service.ServiceType]]</td>
                <td>[[service.Department]]</td>
                <td>[[service.Charges |currency]]</td>
                {{-- <td>[[service.ServingTime]]</td> --}}
                {{-- <td>[[service.IsShowDelayAlert == 1 ? "Yes" : "No" ]]</td>
                <td>[[service.IsQuantitative == 1 ? "Yes" : "No" ]]</td>
                <td>[[service.IsInventory == 1 ? "Yes" : "No" ]]</td> --}}
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-service" ng-click="editService(service)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-service" ng-click="deleteService(service)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
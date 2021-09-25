<div id="partnerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Image</th>
                <th>Hotel</th>
                <th>Rate</th>
                <th>Description</th>
                {{-- <th>Quantity</th> --}}
                <th>Stock Alert</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            {{-- <tr ng-repeat="inventory in inventories| filter :{Title:searchTitle, HotelName:searchHotel, Rate:searchRate, Description:searchDescription }" class="unread">      --}}
            <tr ng-repeat="inventory in inventories" class="unread">     
                <td>[[inventory.Title]]</td>
                <td><img class="img-thumbnail" ng-if="inventory.Image" width="30px" height="auto" ng-src="[[inventory.Image]]"></td>
                <td>[[inventory.HotelName]]</td>    
                <td>[[inventory.Rate]]</td>
                <td>[[inventory.Description]]</td>
                {{-- <td>[[inventory.Quantity]]</td> --}}
                <td><span class="badge badge-[[inventory.Quantity <= inventory.LowStockAlert ? 'danger':'success']]">[[ inventory.Quantity <= inventory.LowStockAlert ? 'Low':'High']] </span></td>
                <td><span class="badge badge-[[inventory.Status == '1' ? 'success':'danger']]">[[ inventory.Status == '1' ? 'Active':'Inactive']] </span></td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-inventory" ng-click="editInventory(inventory)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            {{-- <a id="delete-inventory" ng-click="deleteInventory(inventory)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a> --}}
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
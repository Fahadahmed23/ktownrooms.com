<div id="partnerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Purchase order # </th>
                <th>Purchase Order Date </th>
                <th>No. of Products</th>
                <th>Hotel</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="purchase_order in purchase_orders | filter:{HotelName:searchHotel, PurchaseOrderNumber:searchPO_num}" class="unread">
                <td>[[purchase_order.PurchaseOrderNumber]]</td> 
                <td>[[purchase_order.PurchaseOrderDate | date]]</td>
                <td>[[purchase_order.InventoryCount]]</td>
                <td>[[purchase_order.HotelName]]</td>
                <td><span ng-class="getPoStatus(purchase_order.Status)" class="badge">[[purchase_order.Status]]</span></td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a ng-click="showPoDetail(purchase_order)" class="list-icons-item text-success"><i class="icon-clipboard3"></i></a>   
                            <a ng-if="purchase_order.Status == 'Pending'" ng-click="editPurchaseOrder(purchase_order)" class="list-icons-item text-info"><i class="icon-pencil5"></i></a>   
                            <a ng-if="purchase_order.Status == 'Pending'" ng-click="deletePurchaseOrder(purchase_order)" class="list-icons-item text-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
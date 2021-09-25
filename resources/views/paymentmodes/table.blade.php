<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">PaymentMode Id #</th>
                <th>PaymentMode Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="paymentmode in paymentmodes | filter : filterSearchText" class="unread">
                <td style="display:none;">[[paymentmode.id]]</td>
                <td><span class="letter-icon-title text-default">[[paymentmode.PaymentMode]]</span></td>
                
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-paymentmode" ng-click="editPaymentMode(paymentmode)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-paymentmode" ng-click="deletePaymentMode(paymentmode)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
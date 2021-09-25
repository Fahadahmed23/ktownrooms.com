<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Tax Rate Id #</th>
                <th>Tax</th>
                <th>Tax Rate</th>
                <th>Is Default </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="taxrate in taxrates | filter : filterSearchText" class="unread">
                <td style="display:none;">[[taxrate.id]]</td>
                <td><span class="letter-icon-title text-default">[[taxrate.Tax]]</span></td>
                <td><span class="letter-icon-title text-default">[[taxrate.TaxValue]]</span></td>
                <td><span class="letter-icon-title text-default">[[taxrate.IsDefault == 1 ? "Yes" : "No"]]</span></td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-taxrate" ng-click="editTaxRate(taxrate)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-taxrate" ng-click="deleteTaxRate(taxrate)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
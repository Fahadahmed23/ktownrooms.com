<div id="partnerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>GRN #</th>
                <th>Received Date</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="grn in goods_receive_notes | filter:{GRN_Number:searchGrn_num}" class="unread">     
                <td>[[grn.GRN_Number]]</td>
                <td>[[grn.GRN_Date | date]]</td>    
                <td>[[grn.gTotal | currency]]</td>
                <td>
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a ng-click="showgrnDetail(grn.id)" class="list-icons-item text-success"><i class="icon-clipboard3"></i></a>
                            <a ng-click="deleteGrn(grn)" class="list-icons-item text-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
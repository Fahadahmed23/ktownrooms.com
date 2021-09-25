<div id="fiscalyearTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="fiscalyear in fiscalyears | filter :{title:searchTitle}" class="unread">     
                <td>[[fiscalyear.title]]</td>
                <td>[[fiscalyear.start_date | date]]</td>    
                <td>[[fiscalyear.end_date | date]]</td>
                <td>[[fiscalyear.description]]</td>
                <td>[[ fiscalyear.status]]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-fiscalyear" ng-click="editFiscalYear(fiscalyear)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            <a id="delete-fiscalyear" ng-click="deleteFiscalYear(fiscalyear)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
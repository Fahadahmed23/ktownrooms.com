<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Client</th>
                <th>Type</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="mapping in mappings" class="unread">
                <td>[[mapping.client]]</td>
                <td>[[mapping.type]]</td>
                <td>[[mapping.source]]</td>
                <td>[[mapping.destination]]</td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-inventory" ng-click="editMapping(mapping)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
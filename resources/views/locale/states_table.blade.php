<style>
.table-responsive {
    height: 100%;
    min-height: 600px;
}
</style>
<div id="states-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                    States
            </h5>
            <input type="text" ng-model="searchState" class="srch form-control form-control-lg alpha-grey col-md-5" placeholder="Search">
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-sm btn-primary " ng-click="addState()"><i class="mr-1 icon-plus22"></i>Add</button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="init()"></a>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>State</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="state in states | filter:searchState" class="unread">
                        <td>[[state.StateName]]</td>
                        <td>
                            <div class="align-self-left">
                                <div class="list-icons list-icons-extended">
                                    <a href="javascript:void(0)" ng-click="editState(state)" class="list-icons-item edit-sec"><i class="icon-pencil5"></i></a>
                                    <a ng-click="deleteState(state)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
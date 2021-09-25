<style>
.table-responsive {
    height: 100%;
    min-height: 600px;
}
</style>
<div id="countries-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                    Countries
            </h5>
            <input type="text" ng-model="searchCountry" class="srch form-control form-control-lg alpha-grey col-md-5" placeholder="Search">
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-sm btn-primary " ng-click="addCountry()"><i class="mr-1 icon-plus22"></i>Add</button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="init()"></a>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="country in countries | filter:searchCountry" class="unread">
                        <td>[[country.CountryName]]</td>
                        <td>
                            <div class="align-self-left">
                                <div class="list-icons list-icons-extended">
                                    <a href="javascript:void(0)" ng-click="editCountry(country)" class="list-icons-item edit-sec"><i class="icon-pencil5"></i></a>
                                    <a ng-click="deleteCountry(country)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
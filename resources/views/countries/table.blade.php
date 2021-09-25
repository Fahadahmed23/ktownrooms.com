<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Country Id #</th>
                <th>Country Name</th>
                <th>Abbreviation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="country in countries | filter : filterSearchText" class="unread">
                <td style="display:none;">[[country.id]]</td>
                <td><span class="letter-icon-title text-default">[[country.CountryName]]</span></td>
                <td><span class="letter-icon-title text-default">[[country.Abbreviation]]</span></td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-country" ng-click="editCountry(country)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-country" ng-click="deleteCountry(country)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
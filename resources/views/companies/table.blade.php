

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Companies
            <span><a href="#" class="" ng-click="showFilter()">
                <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
           </a></span>
        </h5>
        <div class="header-elements">
            <div class="list-icons">
                <button type="button" class="btn btn-sm btn-primary " ng-click="createCompany()"><i class="mr-1 icon-plus22"></i>Add New company</button>
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload" ng-click="getCompanies()"></a>

            </div>
        </div>
    </div>
<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Company Id #</th>
                <th>Company Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="company in companies | filter : {id:searchID, CompanyName:searchName } " class="unread">
                <td style="display:none;">[[company.id]]</td>
                <td><span class="letter-icon-title text-default">[[company.CompanyName]]</span></td>
                
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-company" ng-click="editCompany(company)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-company" ng-click="deleteCompany(company)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
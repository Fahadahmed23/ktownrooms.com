<div id="bookings-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
    <div class="card bookingTable">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                    Departments
                    <span><a href="#" class="" ng-click="showFilter()">
                        <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
                   </a></span>
            </h5>
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-sm btn-primary " ng-click="createDepartment()">New Department<i class="ml-1 icon-plus22"> </i></button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="init()"></a>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Company</th>
                       <!-- <th>Service</th>-->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="department in departments |filter : {id:searchID, Department:searchName , CompanyName:searchCompany  }" class="unread">
                        <td><img class="img-thumbnail mr-2" ng-if="department.IconPath" width="30px" height="auto" ng-src="[[department.IconPath]]"> [[department.Department]]</td>
                        <td>[[department.CompanyName]]</td>
                        <!--<td>
                            <ul class="pl-3">
                                <li ng-repeat="service in department.services"><i class="[[service.IconPath]] mr-2"></i>[[service.Service]]</li>
                            </ul>
                        </td>-->
                       

                        <td>
                            <div class="align-self-left">
                                <div class="list-icons list-icons-extended">
                                    <a id="edit-RoomCategory" ng-click="editDepartment(department)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                                    <a id="delete-RoomCategory" ng-click="deleteDepartment(department)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style type="text/css">
    .md-select-menu-container,
    md-backdrop {
        z-index: 999999 !important;
    }
    .bulk_occupant-card{
        background: #eee;
        font-family: monospace;
        border-radius: 3px;
        min-height: 75px;
    }
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div id="showcustomerList" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                Customer-List
                </h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 col-lg-12">
                    <table class="table table-responsive table-user table-striped hover display datatable-basic">
                        <thead>
                            <tr>
                                <th>Customer Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>CNIC</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink">
                            <tr ng-repeat="c in CustomerList" class="unread">
                                <td>[[c.id]]</td>
                                <td>[[c.FirstName]]</td>
                                <td>[[c.LastName]]</td>
                                <td>[[c.CNIC]]</td>
                                <td>[[c.Email]]</td>
                                <td>[[c.Phone]]</td>
                                <td>
                                    <button type="button" ng-click="GetCustomerById(c.id)" class="btn btn-primary">Select</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="partnerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Name</th>
                <th>Hotel</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="partner in partners | filter :{FullName:searchPartner, HotelName:searchHotel, EmailAddress:searchEmail, ContactNo:searchPhone }" class="unread">     
                <td>[[partner.FullName]]</td>
                <td>[[partner.HotelName]]</td>    
                <td>[[partner.EmailAddress]]</td>
                <td>[[partner.ContactNo]]</td>
                <td>[[ partner.Status == 1?'Active':'Not Active']]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-partner" ng-click="editPartner(partner)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            <a id="delete-partner" ng-click="deletePartner(partner)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
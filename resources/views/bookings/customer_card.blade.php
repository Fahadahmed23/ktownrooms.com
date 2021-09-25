<div class="card customercard" style="">
    <div class="card-body" style=" background:#eee;">
        
        <div class="customer-basic">
            <h2 class="mb-0">[[nBooking.customer.FirstName]] [[nBooking.customer.LastName]]
               <span class="float-right mt-2" style="font-size: 13px"> 
                   <small>
                        <a  class="list-icons-item" ng-click="hideCustomerCard()"><i class="icon-pencil5"></i></a>
                    </small>
                </span>
            </h2>
        </div>
        <div class="col-md-12 px-0">
            <div class="customer-cnic" ng-show="nBooking.customer.CNIC">
                <span class="mb-0"><strong>[[nBooking.customer.is_cnic == '0'?'Passport':'Cnic']]:</strong>[[nBooking.customer.CNIC]]</span>
            </div>

            <div class="customer-email">
                <span class="mb-0"><strong>Email:</strong>[[nBooking.customer.Email]]</span>
            </div>
            <div class="customer-phone">
                <span><strong>Phone:</strong>[[nBooking.customer.Phone]]</span>
            </div>

            <div class="customer-nationality">
                <span><strong>Nationality:</strong> <span class="text-uppercase">[[nBooking.customer.nationality]]</span></span>
            </div>

        </div> 



        <div class="col-md-12 px-0">
            <div class="customer-membership text-right">
                <span class="mb-0 "><strong>Member Since:</strong>  [[nBooking.customer.created_at | date]]</span>
            </div>
            <div class="customer-active text-right">
                <span><strong>Status : </strong> [[nBooking.customer.IsActive == 1?'Active':'Not Active']] </span>
            </div>

            <div class="customer-total-bookings text-right">
                <span><strong>Total Bookings: </strong> [[nBooking.customer.bookings_count]] </span>
            </div> 

            <div class="customer-latest-bookings text-right">
                <span ng-show="nBooking.customer.bookings_count > 0"><strong>Latest Booking On : </strong> [[nBooking.customer.LatestBooking | date]] </span>
            </div>
        </div> 
    </div>
</div>
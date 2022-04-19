@extends('layouts.app')
@section('scripts')
    <script src="app/customerbookinglist.controller.js"></script>
@endsection
@section('content')
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
<div class="container-fluid mt-2" ng-controller='bookinglistcltr'>

    <div class="row justify-content-center" ng-init="getCustomerProfileBooking()">
        <div class="col-md-12">
            <div class="card">
                @auth
                <div class="card-header">Welcome {{ Auth::user()->name }}</div>

                <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Hotal Name</th>
                                        <th>Room Title</th>
                                        <th>Room Number</th>

                                        <th>Booking From</th>
                                        <th>Booking To</th>
                                        <th>Status</th>
                                        <th>Booking Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody data-link="row" class="rowlink">
                                    <tr ng-repeat="user in customerbooking" class="unread">
                                        <td>[[user.customer_first_name]] - [[user.customer_last_name]] </td>
                                        <td>[[user.HotelName]]</td>
                                        <td>[[user.rooms[0].room_title]]</td>
                                        <td>[[user.rooms[0].RoomNumber]]</td>
                                        <td>[[user.BookingFrom|date]]</td>
                                        <td>[[user.BookingTo|date]]</td>
                                        <td>[[user.status]]</td>
                                        <td>[[user.BookingDate|date]]</td>
                                        <td>
                                            <div class="align-self-center">
                                                <div class="list-icons list-icons-extended">
                                                    <button type="button"  ng-click="GetBookingDetails(user.id)" class="btn btn-primary" data-popup="tooltip" title="Edit Detail" data-trigger="hover">Details</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
    {{-- Modal Box Start --}}
    <div id="Customerbookingmodel" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                     <h2 class="modal-title text-center">
                        Booking Detail
                    </h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            <div class="modal-body">
                <div class="col-md-12 col-lg-12">
                    <table class="table table-user table-striped hover display datatable-basic">
                        <thead>
                            <tr>
                                <th>Booking Id</th>
                                <th>Booking No</th>
                                <th>No. of Rooms</th>
                                <th>No. of Occupants</th>
                                <th>No. of Nights</th>
                                <th>Per Night Charges</th>
                                <th>Net Total</th>
                                <th>Discount Amount</th>
                                <th>Total</th>

                            </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink">
                            <tr ng-repeat="c in bookingDetails" class="unread">
                                <td>[[c.id]]</td>
                                <td>[[c.booking_no]]</td>
                                <td>[[c.invoice.num_rooms]]</td>
                                <td>[[c.invoice.num_occupants]]</td>
                                <td>[[c.invoice.nights]]</td>
                                <td>[[c.invoice.per_night_charges]]</td>
                                <td>[[c.invoice.net_total]]</td>
                                <td>[[c.invoice.discount_amount]]</td>
                                <td>[[c.invoice.total]]</td>

                                {{-- <td>
                                    <button type="button" ng-click="GetBookingDetails(c.id)" class="btn btn-primary">Select</button>
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Box End --}}
</div>


@endsection

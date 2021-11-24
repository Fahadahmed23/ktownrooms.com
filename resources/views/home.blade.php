@extends('layouts.app')
@section('scripts')
    <script src="app/customerbookinglist.controller.js"></script>
@endsection
@section('content')


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

{{--
                                        <td>
                                            <div class="align-self-center">
                                                <div class="list-icons list-icons-extended">
                                                    <a id="edit-company" ng-click="editUser(user)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>
                                                </div>
                                            </div>
                                        </td> --}}
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
</div>
@endsection

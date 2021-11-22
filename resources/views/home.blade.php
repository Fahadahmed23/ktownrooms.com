@extends('layouts.app')
@section('scripts')
    <script src="app/customerbookinglist.controller.js"></script>
@endsection
@section('content')


<div class="container-fluid mt-2" ng-controller='bookinglistcltr'>
    [[2+6]]
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
                                        <th>Client Name</th>

                                        <th>Phone No.</th>
                                        <th>Cnic</th>
                                        <th>Email</th>
                                        <th>Hotel Name</th>
                                        <th>Booking Status</th>
                                        <th>Booking Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody data-link="row" class="rowlink">
                                    <tr ng-repeat="user in customerbooking.clients" class="unread">
                                        <td>[[user.FullName]]</td>
                                        <td>[[user.customer_last_name]]</td>
                                        <td>[[user.customer_cnic]]</td>
                                        <td>[[user.customer_email]]</td>
                                        <td>[[user.customer_phone]]</td>
                                        <td>Booking status</td>
                                        <td>[[user.checkout_date|date]]</td>
                                        <td>
                                            <div class="align-self-center">
                                                <div class="list-icons list-icons-extended">
                                                    <a id="edit-company" ng-click="editUser(user)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>
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
</div>
@endsection

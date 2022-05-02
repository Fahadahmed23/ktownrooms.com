<!doctype html>
<html lang="en" ng-app="ktown">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="https://www.ktownrooms.com/resources/assets/web/img/favicon.png"
        type="image/x-icon">
    <title style="display: none;">KTOWNROOMS</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/material/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/rescalendar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/angular-material.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/intlTelInput.css')}}">

    <!-- MR OPTIMIST -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">


    <!-- mystyle css -->
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>




    <script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/ui/ripple.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <!-- Theme JS files -->
    <script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/notifications/jgrowl.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>


    <script src="{{asset('global_assets/js/plugins/ui/fullcalendar/core/main.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/ui/fullcalendar/list/main.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js')}}"></script>

    <script src="{{asset('global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>


    <script src="https://kit.fontawesome.com/ff383a412e.js" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/datatables_advanced.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/picker_date.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_checkboxes_radios.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/invoice_template.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_floating_labels.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_validation.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/components_popups.js')}}"></script>
    {{-- <script src="{{asset('global_assets/js/demo_pages/widgets_stats.js')}}"></script> --}}

    {{-- <script src="https://d3js.org/d3.v4.js"></script> --}}

    <!-- Mr Optimist 4 April 2022 -->


     <!--   <script src="{{asset('datatableswork/js/jquery-3.5.1.js')}}"></script> -->
    <script src="{{asset('datatableswork/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatableswork/js/dataTables.buttons.min.js')}}"></script>

    <script src="{{asset('datatableswork/js/jszip.min.js')}}"></script>
    <script src="{{asset('datatableswork/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('datatableswork/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('datatableswork/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('datatableswork/js/buttons.print.min.js')}}"></script>


    <!-- /theme JS files -->


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{asset('global_assets/js/plugins/pickers/color/spectrum.js')}}"></script>
    {{-- <script src="{{asset('global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script> --}}
    <script src="{{asset('global_assets/js/demo_pages/picker_color.js')}}"></script>
    <!-- /theme JS files -->

    <script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('assets/js/toastr.js')}}"></script>
    <script src="{{asset('assets/js/slick.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script src="{{asset('assets/js/utils.js')}}"></script>
    <script src="{{asset('assets/js/rescalendar.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular.min.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular-animate.min.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular-aria.min.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular-messages.min.js')}}"></script>
    <script src="{{asset('assets/js/angular-datatables.min.js')}}"></script>
    <!-- Mr Optimist 5 April 2022 -->
    <script src="{{asset('assets/js/angular-datatables.buttons.js')}}"></script>
      <!--  Mr Optimist 5 April 2022 ends -->

    <script src="{{asset('assets/js/angular-sanitize.min.js')}}"></script>
    <script src="{{asset('assets/js/angular-material.min.js')}}"></script>
    <script type="text/javascript"
        src="https://cdn.rawgit.com/AlphaGit/ng-pattern-restrict/master/src/ng-pattern-restrict.min.js"></script>
    <script src="{{asset('assets/js/angular-pagination.js')}}"></script>
    <script src="{{asset('app/app-report.js')}}"></script>

    <script src="{{asset('global_assets/js/demo_pages/form_multiselect.js')}}"></script>

    @yield('scripts')



    <style>
        input[type=checkbox][data-fouc],
        input[type=radio][data-fouc] {
            visibility: visible;
        }
    </style>


    <style>
        .list-icons.row a {
            width: 100%;
        }

        .list-icons.row a:hover {
            background-color: lightgrey;
        }

        .list-icons.row span {
            margin-right: 15px;
        }
    </style>
    <style>
        .ColVis,
        .ColVis_collection {
            display: none !important;
        }


        .sidebar-component-hidden .sidebar-component-left {
            display: none !important;
        }

        .breadcrumb-line-light .header-elements.d-none {
            display: none !important;
        }

        span.required {
            color: red;
        }

        .dropdown-item {
            /* text-align: left !important; */
        }

        .content {
            padding: 0.65rem 0.65rem !important;
        }

        .card {
            margin-bottom: 0.65rem !important;
        }

        .sidebar.sidebar-light {
            margin-right: 0.3125rem !important;
        }

        .form-group {
            margin-bottom: 0.25rem !important;
        }

        .floating-label {
            margin-bottom: 16px !important;
        }

        .form-control {
            height: calc(1.6667em + .625rem + 2px);
            padding: .3125rem .75rem;
            font-size: .75rem;
            line-height: 1.6667;
            border-radius: .125rem;
        }

        .btn {
            padding: .3125rem .75rem !important;
            font-size: .75rem !important;
            line-height: 1.6667 !important;
            border-radius: .125rem !important;
        }

        .card-header:not([class*=bg-]):not([class*=alpha-]) {
            padding-top: 0.65rem !important;
            padding-bottom: 0.65rem !important;
        }

        .dataTables_wrapper {
            padding: 0rem !important;
        }

        .card-body {
            padding: .65rem !important;
        }

        .fc-toolbar.fc-header-toolbar {
            margin-bottom: .20rem !important;
        }

        table.dataTable,
        table.dataTable.no-footer {
            margin: 0.5rem 0 !important;
        }

        #schedule-vol-tbl_wrapper .dataTables_length {
            display: none !important;
        }

        .dataTables_info {
            margin-bottom: 0rem !important;
        }

        .dataTables_paginate {

            margin: 0 0 0 1.25rem !important;

        }

        .dataTables_info {
            padding: 0 !important;
            /* padding: .5rem 0; */

        }

        .admin_name:hover {
            color: black;
            text-decoration: none;
            background-color: transparent;
        }

        .selectedtr {
            border: 2px solid black;
            border-style: solid;
        }

        .dashboard .btn-primary:not([type=submit]) {
            border-radius: 500px !important;
            height: 20px !important;
            line-height: .5185 !important;
        }

        .dataTables_length {
            display: none;
        }

        .bg-pink-400 {
            background-color: rgb(63 81 181 / 34%) !important;
        }

        [class*=bg-]:not(.bg-transparent):not(.bg-light):not(.bg-white):not(.bg-pink-800):not(.btn-outline):not(body) {
            color: #fff !important;
        }

        .bg-pink-800,
        .ribbon {
            color: #fff !important;
            background-color: #2196f3 !important;
        }

        *:not(.form-control):focus {
            outline: none !important;
            border: 0 !important;
        }

        #sortable h6 {
            cursor: pointer;
        }

        .noti-icon:after {
            content: "";
            height: 10px;
            width: 10px;
            background: #fc7044;
            position: absolute;
            border-radius: 20px;
            top: -4px;
            left: 14px;
        }

        .acpt_rjct_btn {
            cursor: pointer;
        }
        .service-noti-pill div {
            display: inline-block;
        }
        /* .navbar a {
            color: #324148;
        } */




        /* my navbar css */
        /* .navbar-top-menu
        {
            background: #ea883f;
        } */
        .navbar-top-menu .nav-item a {
            padding-top: 0;
            padding-bottom: 0;
        }
        .navbar-top-menu .navbar-brand {
            padding: 0 ;
        }
        .navbar-nav.ml-xl-auto.d-inline{
            display: inline-block !important;
        }

        .navbar-top-menu .nav-item .dropdown-item {
            padding: 10px 15px;
        }
    </style>

</head>

<body class="sidebar-component-hidden" ng-controller="baseCtrl" ng-cloak>

    <!-- Main navbar -->
    @auth
    <div class="navbar navbar-expand-xl navbar-dark navbar-component mb-0 navbar-top-menu">
        {{-- <div class="navbar navbar-expand-xl border-bottom-orange border-bottom-2 navbar-component mb-0"> --}}
        <div class="navbar-brand">
            <a href="/" class="d-inline-block">
                {{-- <img class="logo-icon" src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt=""> --}}
                @php
                $img = \App\Models\DefaultRule::first()->picture;
                @endphp
                @if($img)
                <img class="logo-icon"  src="{{$img}}" alt="">
                @else
                <img class="logo-icon"  src="global_assets/images/new-ktr-logo.png" alt="">
                @endif


            </a>
        </div>

        <div class="d-xl-none">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-demo-dark">
                <i class="icon-menu"></i>
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-demo-dark">
            <ul class="navbar-nav">

                @permission('can-view-room-dashboard')
                <li class="nav-item">
                    <a href="/dashboard" class="navbar-nav-link">Dashboard</a>
                </li>
                @endpermission
                @permission('can-view-hotel-dashboard')
                <li class="nav-item">
                    <a href="/hotel_dashboard" class="navbar-nav-link">Hotel Dashboard</a>
                </li>
                @endpermission

                @permission('can-view-report')
                <li class="nav-item">
                    <a href="/reports" class="navbar-nav-link">Reports</a>
                </li>
                @endpermission
                    {{-- New Reports View - Start - Arman Ahmad 18-03-2022 --}}


                @permission('can-view-report')
                <li class="nav-item">
                    <a href="/reports_new_main" class="navbar-nav-link">Reports-New</a>
                </li>
                @endpermission


                {{-- New Reports View - End - Arman Ahmad 18-03-2022 --}}


                {{-- New Reports View FDO - Start - Arman Ahmad 12-04-2022 --}}

                @permission('can-view-hotel-dashboard')
                <li class="nav-item">

                    <a href="/reports_new_main" class="navbar-nav-link">Reports-New</a>

                </li>
                @endpermission


                {{-- New Reports View FDO - End - Arman Ahmad 12-04-2022 --}}


                <li class="nav-item">
                    @permission('can-view-frontdesk-booking')
                    <a href="/frontdesk" class="navbar-nav-link">Frontdesk</a>
                    @endpermission
                </li>

                <li class="nav-item">
                    @permission('can-view-booking-calendar')
                    <a href="/bookings_calendar" class="navbar-nav-link">Bookings Calendar</a>
                    @endpermission
                </li>

                <li class="nav-item">
                    @permission('can-only-view-discount-request')
                    <a href="/my_requests" class="navbar-nav-link">Discount Requests</a>
                    @endpermission
                </li>

                @if (auth()->user()->can('can-view-booking')|| auth()->user()->can('can-view-booking-mappings') )
                    <li class="nav-item dropdown ">
                        <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown"
                            aria-expanded="true">Bookings</a>
                        <div class="dropdown-menu ">
                            @permission('can-view-booking')
                            <a href="/bookings" class="dropdown-item">Booking Management</a>
                            @endpermission

                            @permission('can-view-booking-mappings')
                            <a href="/booking_mappings" class="dropdown-item">Mapping</a>
                            @endpermission
                        </div>
                    </li>
                @endif


                @permission('can-view-hotel')
                <li class="nav-item">
                    <a href="/hotel" class="navbar-nav-link">Hotels</a>
                </li>
                @endpermission

                @if (auth()->user()->can('can-view-room')|| auth()->user()->can('can-view-room-category') )
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown"
                        aria-expanded="true">Rooms</a>
                    <div class="dropdown-menu ">
                        @permission('can-view-room')
                        <a href="/nrooms" class="dropdown-item">Rooms</a>
                        @endpermission
                        @permission('can-view-room-category')
                        <a href="/rcategories" class="dropdown-item">Room Categories</a>
                        @endpermission
                    </div>
                </li>
                @endif



                @if (auth()->user()->can('can-view-user')|| auth()->user()->can('can-view-role') )
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown"
                        aria-expanded="true">Users</a>
                    <div class="dropdown-menu ">
                        @permission('can-view-user')
                        <a href="/users" class="dropdown-item">User</a>
                        @endpermission
                        @permission('can-view-role')
                        <a href="/roles" class="dropdown-item ">Role</a>
                        @endpermission
                    </div>
                </li>
                @endif





                @if (auth()->user()->hasRole('Admin') || auth()->user()->can('can-view-department') || auth()->user()->can('can-view-company') ||
                auth()->user()->can('can-view-facility') || auth()->user()->can('can-view-service') ||
                auth()->user()->can('can-view-locale') || auth()->user()->can('can-view-lookup') ||
                auth()->user()->can('can-view-promotion') || auth()->user()->can('can-view-partner') ||
                auth()->user()->can('can-view-vendor') || auth()->user()->can('can-view-customers')|| auth()->user()->can('can-view-corporate-client'))
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown"
                        aria-expanded="true">Setup</a>
                    <div class="dropdown-menu ">
                        @if (auth()->user()->hasRole('Admin'))
                        <a href="/default_setting" class="dropdown-item">Default Setting</a>
                        @endif
                        @permission('can-view-department')
                        <a href="/ndepartments" class="dropdown-item">Departments</a>
                        @endpermission

                        @permission('can-view-company')
                        <a href="/companies" class="dropdown-item">Company</a>
                        @endpermission

                        @permission('can-view-facility')
                        <a href="/facilities" class="dropdown-item">Facility</a>
                        @endpermission

                        @permission('can-view-service')
                        <a href="/services" class="dropdown-item">Service</a>
                        @endpermission

                        @permission('can-view-locale')
                        <a href="/locale" class="dropdown-item">Locale</a>
                        @endpermission

                        @permission('can-view-lookup')
                        <a href="/types" class="dropdown-item">Lookup</a>
                        @endpermission

                        @permission('can-view-promotion')
                        <a href="/promotions" class="dropdown-item">Promotion</a>
                        @endpermission

                        @permission('can-view-partner')
                        <a href="/partners" class="dropdown-item">Partner</a>
                        @endpermission

                        @permission('can-view-corporate-client')
                        <a href="/corporate_clients" class="dropdown-item">Corporate Client</a>
                        @endpermission

                        <a href="/general_clients" class="dropdown-item">General Client</a>

                        @permission('can-view-customers')
                        <a href="/customers" class="dropdown-item">Customers</a>
                        @endpermission

                        @permission('can-view-vendor')
                        <a href="/vendors" class="dropdown-item">Vendors</a>
                        @endpermission
                    </div>
                </li>
                @endif

                @if (auth()->user()->can('can-view-inventory') || auth()->user()->can('can-view-purchase-order'))
                    <li class="nav-item dropdown">
                        <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown"
                            aria-expanded="true">Inventory</a>
                        <div class="dropdown-menu ">
                            @permission('can-view-inventory')
                            <a href="/inventory" class="dropdown-item">Inventory Management</a>
                            @endpermission
                            @permission('can-view-purchase-order')
                            <a href="/purchase_orders" class="dropdown-item">Purchase Orders</a>
                            @endpermission
                        </div>
                    </li>
                @endif


                @if (auth()->user()->can('view-account-heads') || auth()->user()->can('can-view-voucher-posting') ||
                        auth()->user()->can('can-view-trial-balance-sheet') || auth()->user()->can('view-approve-vouchers') ||
                        auth()->user()->can('view-fiscal-year') || auth()->user()->can('can-view-account-lookup') ||
                        auth()->user()->can('can-view-general-ledger') ||
                        auth()->user()->can('can-view-income-statement') || auth()->user()->can('can-view-balance-sheet') ||
                        auth()->user()->can('can-view-auto-posting'))
                    <li class="nav-item dropdown">
                        <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown"
                            aria-expanded="true">Accounts </a>
                        <div class="dropdown-menu ">

                            @permission('view-account-heads')
                            <a href="/account_general_ledgers" class="dropdown-item">Chart of accounts</a>
                            @endpermission

                            @permission('can-view-voucher-posting')
                            <a href="/vouchers" class="dropdown-item">Voucher Posting</a>
                            @endpermission

                            @permission('can-view-trial-balance-sheet')
                            <a href="/trialbalancesheet" class="dropdown-item">Trial Balance Sheet</a>
                            @endpermission

                            @permission('view-approve-vouchers')
                            <a href="/posted_vouchers" class="dropdown-item">Approve Voucher</a>
                            @endpermission

                            @permission('view-fiscal-year')
                            <a href="/account_fiscalyears" class="dropdown-item">Fiscal Years</a>
                            @endpermission

                            @permission('can-view-general-ledger')
                            <a href="/ledger" class="dropdown-item">General Ledger</a>
                            @endpermission

                            @permission('can-view-income-statement')
                            <a href="/income_statement" class="dropdown-item">Income Statement</a>
                            @endpermission

                            @permission('can-view-balance-sheet')
                            <a href="/balance_sheet" class="dropdown-item">Balance Sheet</a>
                            @endpermission

                            @permission('can-view-account-lookup')
                            <a href="/account_lookups" class="dropdown-item">Lookups</a>
                            @endpermission

                            @permission('can-view-auto-posting')
                            <a href="/auto_postings" class="dropdown-item">Auto Posting</a>
                            @endpermission
                        </div>
                    </li>
                @endif

                @permission('can-view-discount-request')
                <li class="nav-item">
                    <a href="/discountrequests" class="navbar-nav-link">Discount Approval</a>
                </li>
                @endpermission
                @permission('can-view-task')
                <li class="nav-item">
                    <a href="/tasks" class="navbar-nav-link">Tasks</a>
                </li>
                @endpermission

                @permission('can-view-leaves-calendar')
                <li class="nav-item">
                    <a href="/all_leaves" class="navbar-nav-link">Leaves Calendar</a>
                </li>
                @endpermission

                @permission('can-view-complain')
                <li class="nav-item">
                    <a href="/complains" class="navbar-nav-link">Complain View</a>
                </li>
                @endpermission

                @permission('can-view-hotel-booking-services')
                <li class="nav-item">
                    <a href="/hotel_booking_services" class="navbar-nav-link">Booking Services</a>
                </li>
                @endpermission

            </ul>


            <ul class="navbar-nav ml-xl-auto">
                @if (auth()->user()->hasRole('Frontdesk'))
                @permission('can-view-frontdesk-booking')
                <li class="nav-item nav-item-dropdown-lg dropdown noti_icon">
                    <button ng-click="showNotifications()"
                        class="navbar-nav-link navbar-nav-link-toggler border-0 bg-transparent" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="mi-notifications-active"><span ng-if="new_service_available"
                                class="noti-icon"></span></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                        <div class="dropdown-content-header border-bottom mb-2 p-2">
                            <span class="font-weight-semibold">Notifications</span>
                        </div>

                        <div class="dropdown-content-body dropdown-scrollable">
                            <span ng-if="booking_services.length < 1">No Requested Service</span>
                                <div class="row border-bottom" id="service[[bs.id]]" ng-repeat="bs in booking_services">
                                    <div class="service-noti-pill">
                                        <div class="service-quantity">
                                            <span>[[bs.times]]</span>
                                        </div>
                                        <div class="service-title">
                                            <span><b> [[bs.service_name]]</b></span>
                                        </div>
                                        <div class="service-room">
                                            <span> at Room: <b>[[bs.RoomTitle]]</b> (Room# [[bs.RoomNumber]])</span>
                                        </div>
                                    </div>
                                    <div class="text-muted col-md-12 pb-1 px-0">
                                            <span
                                                class="badge badge-success acpt_rjct_btn"
                                                ng-click="acceptRejectBService(bs.id ,'accepted')"> Accept
                                            </span>
                                            <span
                                                class="badge badge-danger acpt_rjct_btn ml-1"
                                                ng-click="acceptRejectBService(bs.id ,'rejected')">Reject
                                            </span>

                                    </div>
                                </div>
                        </div>

                        <div class="dropdown-content-footer justify-content-center p-0">
                            @permission('can-view-hotel-booking-services')
                            <a href="/hotel_booking_services" target="_blank"
                                class="btn btn-light btn-block border-0 rounded-top-0" data-popup="tooltip" title=""
                                data-original-title="Load more"><i class="icon-menu7"></i> See All </a>
                            @endpermission
                        </div>
                    </div>
                </li>
                @endpermission
                @endif
            </ul>

        </div>

    </div>
    @endauth


    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Page header -->
            @auth
            <div class="page-header page-header-light">
                <div ng-hide="loc.absUrl().search('reports') > -1 || loc.absUrl().search('report') > -1"
                    class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="/home" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                            <span class="breadcrumb-item active">@isset($breadcrumb) {{ $breadcrumb }} @endisset
                                @empty($breadcrumb) Dashboard @endempty</span>
                        </div>

                        <a href="javascript:void(0)" class="header-elements-toggle text-default d-md-none"><i
                                class="icon-more"></i></a>
                    </div>
                    <div class="float-right">

                        <ul class="navbar-nav ml-xl-auto d-inline">
                            <li class="nav-item dropdown dropdown-user">
                                <b class="navbar-nav-link d-flex align-items-center dropdown-toggle cursor-pointer" data-toggle="dropdown">
                                    {{-- <img src="global_assets/images/placeholders/placeholder.jpg" class="rounded-circle mr-2" height="34" alt=""> --}}
                                    <i class="icon-user mr-1"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </b>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="/profile" class="dropdown-item"><i class="icon-user"></i> My profile</a>
                                    @permission('can-view-shift-handover')
                                    <a href="/shift_handover" class="dropdown-item"><i class="icon-transmission"></i>Shift Handover</a>
                                    @endpermission
                                    <a href="javascript:void(0)" class="dropdown-item d-none">
                                        <a href="javascript:void(0)" class="dropdown-item d-none">
                                            <i class="icon-comment-discussion"></i>
                                            My Tasks
                                            <span class="badge badge-pill bg-blue ml-auto">58</span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0)" class="dropdown-item d-none"><i class="icon-cog5"></i> Account
                                            settings</a>
                                        <form method="POST" action="/logout">
                                            {{ csrf_field() }}
                                            <button type="submit" class="dropdown-item"><i class="icon-switch2"></i> Logout
                                    </a>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="header-elements d-none">
                        {{-- <div class="breadcrumb justify-content-center d-none">
                            <form action="#">
                                <div class="input-group">
                                    <div class="form-group-feedback">
                                        <input type="text" class="srch form-control form-control-lg alpha-grey"
                                            placeholder="Search">
                                        <div class="form-control-feedback dleft form-control-feedback-lg">
                                            <i class="icon-search4 text-muted"></i>
                                        </div>
                                        <a href="javascript:void(0)" class="form-control-feedback dright text-warning">
                                            <div>
                                                <i class="icon-arrow-right7"></i>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </form>

                        </div> --}}
                    </div>
                </div>
            </div>
            @endauth
            <!--/page header-->



            <!-- Content area -->

            @yield('content')
            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                        data-target="#navbar-footer">
                        <i class="icon-unfold mr-2"></i>
                        Footer
                    </button>
                </div>

                <div class="navbar-collapse collapse" id="navbar-footer">
                    <span class="navbar-text">
                        © 2019 - 2020. <a href="https://www.ktownrooms.com">KTownRooms</a> All rights reserved
                    </span>

                    <ul class="navbar-nav ml-lg-auto">
                        <li class="nav-item"><a href="https://www.ktownrooms.com/terms-conditions"
                                class="" target="_blank"><i class="icon-file-text2 mr-2"></i>
                                Terms & Conditions</a></li>

                    </ul>
                </div>
            </div>


            <!-- /footer -->

        </div>
        <!-- /main content -->
    </div>

</body>

<script type="text/javascript">
    // for international phone number dropdown with masking





    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    dUrl = "DataTables_DataTables_Table_0_";

    $(document).on('change','.logo',function(){
        var imgctrl = $(this).closest('.wrapper').find('img')
            let img = new Image();
            let file = $(this)[0].files[0];
            if(!file)
            return;
            img.src = URL.createObjectURL(file);
            img.onload = function() {
                imgctrl.show();
                imgctrl.attr('src', URL.createObjectURL(file));
            };

    })


    $(function() {
        $('.upload-logo').click(function(e) {
            e.preventDefault();
            elem = $(this);
            logoctrl = elem.closest('.row').find('.logo');
            if (logoctrl.val()) {
                let formData = new FormData();
                let file = logoctrl[0].files[0];
                formData.append('image', file);
                ShowLoader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    url: '/admin/saveProfilePicture',
                    success: function(response) {
                        var response = JSON.parse(response);
                        if (response.success) {
                            toastr.success('File uploaded successfully', 'Success');
                            var controllername = document.getElementById('main-content').getAttribute("ng-controller")
                            var scope = angular.element(document.querySelector('[ng-controller="' + controllername + '"]')).scope();
                            HideLoader()
                            scope.$apply(function() {
                                switch (controllername) {
                                    case "usersCtrl":
                                        scope.user.picture = response.payload;
                                        break;
                                    case "staffCtrl":
                                        if (elem.attr('name') == "staff")
                                            scope.staffForm.picture = response.payload;
                                        else
                                            scope.familyMemberObj.picture = response.payload;
                                        break;
                                    case "memberCtrl":
                                    case "incomingcallCtrl":
                                        if (elem.attr('name') == "member")
                                            scope.memberForm.picture = response.payload;
                                        else
                                            scope.familyMemberObj.picture = response.payload;
                                        break;
                                    case "adminDefaultCtrl":
                                        scope.defaultSettingsForm.picture = response.payload;
                                        break;
                                    case "volunteerCtrl":
                                        scope.volunteerForm.picture = response.payload;
                                        break;
                                    case "profileCtrl":
                                        scope.profile.picture = response.payload;
                                        break;
                                    case "roomCtrl":
                                        scope.room.thumbnail = response.payload;
                                        break;
                                    case "hotelCtrl":
                                        scope.hotel.mapimage = response.payload;
                                        break;
                                    case "inventoryCtrl":
                                        scope.inventory.Image = response.payload;
                                        break;
                                    case "facilitiesCtrl":
                                        scope.facility.Image = response.payload;
                                        break;
                                    case "servicesCtrl":
                                        scope.service.IconPath = response.payload;
                                        break;
                                    case "departmentCtrl":
                                        scope.department.IconPath = response.payload;
                                        break;
                                    default:
                                        break;
                                }
                            })

                        }
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.errors.image[0]);
                        HideLoader();
                    }
                })

            } else {
                toastr.warning('Please select a file to upload', 'Warning');
                HideLoader();
            }
        })

        $('.upload-mail-img').click(function(e) {
            e.preventDefault();
            elem = $(this);
            logoctrl = elem.closest('.row').find('.logo');
            if (logoctrl.val()) {
                let formData = new FormData();
                let file = logoctrl[0].files[0];
                formData.append('image', file);
                ShowLoader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType

                    url: 'mailImage',
                    success: function(response) {
                        var response = JSON.parse(response);
                        if (response.success) {
                            toastr.success('File uploaded successfully', 'Success');
                            var controllername = document.getElementById('main-content').getAttribute("ng-controller")
                            var scope = angular.element(document.querySelector('[ng-controller="' + controllername + '"]')).scope();
                            HideLoader()
                            scope.$apply(function() {
                                switch (controllername) {
                                    case "hotelCtrl":
                                    scope.hotel.mailimage = response.payload;
                                    break;
                                }
                            })

                        }
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.errors.image[0]);
                        HideLoader();
                    }
                })

            } else {
                toastr.warning('Please select a file to upload', 'Warning');
                HideLoader();
            }
        })


         $('.upload-pos-img').click(function(e) {
            e.preventDefault();
            elem = $(this);
            logoctrl = elem.closest('.row').find('.logo');
            if (logoctrl.val()) {
                let formData = new FormData();
                let file = logoctrl[0].files[0];
                formData.append('image', file);
                ShowLoader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType

                    url: 'posImage',
                    success: function(response) {
                        var response = JSON.parse(response);
                        if (response.success) {
                            toastr.success('File uploaded successfully', 'Success');
                            var controllername = document.getElementById('main-content').getAttribute("ng-controller")
                            var scope = angular.element(document.querySelector('[ng-controller="' + controllername + '"]')).scope();
                            HideLoader()
                            scope.$apply(function() {
                                switch (controllername) {
                                    case "hotelCtrl":
                                    scope.hotel.posimage = response.payload;
                                    break;
                                }
                            })

                        }
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.errors.image[0]);
                        HideLoader();
                    }
                })

            } else {
                toastr.warning('Please select a file to upload', 'Warning');
                HideLoader();
            }
        })

    $(document).on('click','.upload-images',function(e){
            e.preventDefault();
            elem = $(this);
            logoctrl = elem.closest('.row').find('.logo');
            if (logoctrl.val()) {
                let formData = new FormData();
                let file = logoctrl[0].files[0];
                formData.append('image', file);
                ShowLoader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    url: '/saveImages',
                    success: function(response) {
                        var response = JSON.parse(response);
                        if (response.success) {
                            toastr.success('File uploaded successfully', 'Success');
                            var controllername = document.getElementById('main-content').getAttribute("ng-controller")
                            var scope = angular.element(document.querySelector('[ng-controller="' + controllername + '"]')).scope();
                            HideLoader()
                            scope.$apply(function() {
                                switch (controllername) {
                                    case "roomCtrl":
                                        scope.room.images.push({id: scope.room.images.length, ImagePath: response.payload});
                                        // ().attr('src', URL.createObjectURL(file));
                                        console.log(scope.room.images);
                                        console.log(response);
                                        break;
                                    default:
                                        break;
                                }
                            })
                            // after succes upload show this as img thumbnail
                            $('.previewroomimg').attr('src', 'https://www.new.dominionembassygh.org/wp-content/uploads/2018/10/accommodate.png');
                            $("#selectimage").val('');

                        }
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.errors.image[0]);
                    }
                })

            } else {
                toastr.warning('Please select a file to upload', 'Warning');
            }

    })



// excel upload

$(document).on('click','.excel-upload',function(e){
            e.preventDefault();
            elem = $(this);
            // excelsheet = $('.excel-sheet').val();
            // console.log(excelsheet);
            // return;
             excelsheet = $('.excel-sheet');
            if (excelsheet.val()) {
                let formData = new FormData();
                let file = excelsheet[0].files[0];
                // let file = excelsheet.val();
                formData.append('excelfile', file);
                // ShowLoader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    url: '/importExcel',
                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        // if (response.success) {
                        //     toastr.success('File uploaded successfully', 'Success');
                        //     var controllername = document.getElementById('main-content').getAttribute("ng-controller")
                        //     var scope = angular.element(document.querySelector('[ng-controller="' + controllername + '"]')).scope();
                        //     HideLoader();
                        //     scope.$apply(function() {
                        //         switch (controllername) {
                        //             case "corporateclientsCtrl":
                        //                 scope.room.images.push({id: scope.room.images.length, ImagePath: response.payload});
                        //                 // ().attr('src', URL.createObjectURL(file));
                        //                 console.log(scope.room.images);
                        //                 console.log(response);
                        //                 break;
                        //             default:
                        //                 break;
                        //         }
                        //     })
                        //     // after succes upload show this as img thumbnail
                        //     $('.previewroomimg').attr('src', 'https://www.new.dominionembassygh.org/wp-content/uploads/2018/10/accommodate.png');
                        //     $("#selectimage").val('');

                        // }
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.errors.excelfile[0]);
                    }
                })

            } else {
                toastr.warning('Please select a file to upload', 'Warning');
            }

    })






    });
</script>
<script type="text/javascript">
    // $(document).on( "keypress", "input[data-type='currency']", function(evt) {
//   console.log( $( this ).text() );
// });

$(document).on({
            keypress: function(evt) {
                a = $(this);
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode != 46)
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                else if (a.attr('length') != undefined) {
                    if (a.val().indexOf('.') > -1 && a.val().split('.')[1].length != 2)
                        return true;
                    if (a.val().split('.')[0].replace(/,/g, "").length >= a.attr('length'))
                        return false;
                }

                return true;
            },
            keyup: function() {

                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        },"input[data-type='currency']");
        $("input[data-type='number_format']").on({
            keypress: function(evt) {
                a = $(this);
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode != 46)
                    if (charCode == 190)
                        return false;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                } else if (a.attr('length') != undefined) {
                    if (a.val().indexOf('.') > -1 && a.val().split('.')[1].length != 2)
                        return true;
                    if (a.val().split('.')[0].replace(/,/g, "").length >= a.attr('length'))
                        return false;
                }

                return true;
            },
            keyup: function() {

                number_formatter($(this));
            }
        });
        function number_formatter(input) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);



            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;


            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }



        function scrollTop() {
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            }, 100);

            $('.alert').hide();
            $('.card-collapsed').removeClass('card-collapsed').find('.card-body').show();
            $('.rotate-180').removeClass('rotate-180');
        }

        function ShowLoader() {
            $.blockUI.defaults.baseZ = 4000;
            $.blockUI({
                message: '<i class="icon-spinner2 spinner" style="font-size: xxx-large;"></i>',
                overlayCSS: {
                    backgroundColor: 'white',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: 'black',
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
            // document.getElementById("hideAll").style.display = "block";

        }

        function HideLoader() {
            //setTimeout(() => {
            $.unblockUI();
            //}, 500);

        }
        var block = "";
        //var first = true;

        function ShowLoaderTb(classnAME) {
            // if (first == false)
            //     return;
            block = $('.flex-fill .card');
            if(classnAME != undefined)
            block = $('.'+classnAME+' .card');

            setTimeout(() => {
                $(block).block({
                    message: '<span class="font-weight-semibold"><i class="icon-spinner4 spinner mr-2"></i>&nbsp; Fetching Data</span>',
                    //timeout: 2000, //unblock after 2 seconds
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: '10px 15px',
                        color: '#fff',
                        width: 'auto',
                        '-webkit-border-radius': 3,
                        '-moz-border-radius': 3,
                        backgroundColor: '#333'
                    }
                });
            }, 300);

        }

        function HideLoaderTb() {
            block.unblock();
        }

        function site_url(url) {
            return '{{site_url()}}/' + url;
        }

        function asset_url(url) {
            return '{{asset_path()}}/' + url;
        }
        $('.sidebar :input[type="text"]').on('keypress', function(e) {
            if (e.which == 13) {
                // $('.sidebar button:first').click();
                $('.sidebar .btn-block:first').click();
            }
        });

        // $('.sidebar').on("click", ".btn-block", function() {
        //     ShowLoaderTb();
        //     first = false;
        // });

        //$('.sidebar select').change(function(){$('.sidebar button:first').click()})
        $('.sidebar-control').click(function() {
            $('#icon-shift').toggleClass('icon-drag-right icon-drag-left');
            $(".sidebar").toggle();
            $('.sidebar .card-collapsed').removeClass('card-collapsed').find('.card-body').show();
            $('.sidebar .rotate-180').removeClass('rotate-180');
            //$('.datatable-basic').DataTable().columns.adjust().draw();
        });


        // $('.phone_us').mask('0000-0000000');
        // $('.extension_us').mask('00000');
        // $('.zip_us').mask('00000');
        // $('.num3').mask('000')
        // $('.num2').mask('00');
        // $('.cnic').mask('00000-0000000-0');
        // $('.cardnumber').mask('0000 0000 0000 0000');
        // $('.cvc').mask('0000');
        // $('.expiry_date').mask('00/00');
        // $('.chequenumber').mask('0000000000000000000000000');
        // $('.latlng').mask('~00#.00000000', {
        //     translation: {
        //         '~': {
        //             pattern: /-/, optional:true
        //         }
        //     }
        // });
        // $('.email_mask').mask("AN@ANC", {
        //     translation: {
        //         "A": { pattern: /[a-z]/ },
        //         "N": { pattern: /[a-z0-9]/, recursive:"true"},
        //         "C": { pattern: /.([a-z0-9])/, recursive:"true"}
        //     }
        // });

        function applyMask() {
            $('.phone_us').mask('0000-0000000');
            // $('.phone_int').mask('0000000000000000');
            $('.extension_us').mask('00000');
            $('.zip_us').mask('00000');
            $('.num3').mask('000');
            $('.num4').mask('0000');
            $('.num2').mask('00');
            $('.percent').mask("99.9%");
            $('.cnic').mask('00000-0000000-0');
            $('.cardnumber').mask('0000 0000 0000 0000');
            $('.cvc').mask('0000');
            $('.expiry_date').mask('00/00');
            $('.date_format').mask('39-19-0000');
            // $('.chequenumber').mask('00000000-0000000-00000000000000000-000');
            $('.cheque').mask('00000000');
            $('.gl_code').mask('00-00-00-00-000');
            //$('cheque_number'.mask(''))
            $('.latlng').mask('~00r.00000000', {
                translation: {
                    '~': {
                        pattern: /-/, optional:true
                    },
                    'r': {
                        pattern: /[0-9]/, optional:true
                    }
                }
            });
            $('.email_mask').mask("E", {
                translation: {
                    "E": { pattern: /[\w@\-.+]/, recursive: true }
                }
            }, placeholder="abc@example.com");

            $('.alphabets').mask('A',
                {'translation':
                    {
                        A: {pattern: /[A-Z . a-z .]/ , recursive: true},
                    }
            });

            $('.alpha_numeric').mask('A',
                {'translation':
                    {
                        A: {pattern: /[A-Z a-z 0-9.]/ , recursive: true},
                    }
            });
        }

        applyMask()

        $('.flex-fill a[data-action="reload"]').click(function() {
            //$('.sidebar-content .btn:eq(1)').click();
            if ($(this).prev().hasClass('rotate-180'))
                $(this).prev().click();
        })



</script>





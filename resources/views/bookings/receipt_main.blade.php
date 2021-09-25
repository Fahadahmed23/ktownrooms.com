<!doctype html>
<html lang="en" ng-app="ktown">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="csrf-token" content="{{ csrf_token() }}" />   
    <link rel="shortcut icon" href="https://www.ktownrooms.com/resources/assets/web/img/favicon.png" type="image/x-icon">
	<title>KTOWNROOMS</title>
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
    <script src="https://kit.fontawesome.com/ff383a412e.js" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/datatables_advanced.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/picker_date.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_checkboxes_radios.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/invoice_template.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_floating_labels.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/form_validation.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/components_popups.js')}}"></script>
    <!-- /theme JS files -->

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{asset('global_assets/js/plugins/pickers/color/spectrum.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/picker_color.js')}}"></script>
	<!-- /theme JS files -->

    <script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('assets/js/toastr.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular.min.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular-animate.min.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular-aria.min.js')}}"></script>
    <script src="{{asset('assets/js/angular/angular-messages.min.js')}}"></script>
    <script src="{{asset('assets/js/angular-datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/angular-sanitize.min.js')}}"></script>
    <script src="{{asset('assets/js/angular-material.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/AlphaGit/ng-pattern-restrict/master/src/ng-pattern-restrict.min.js"></script>
    <script src="{{asset('assets/js/angular-pagination.js')}}"></script>
    <script src="{{asset('app/app.js')}}"></script>

    @yield('scripts')

    <script src="{{url('app/bookings-controller.js')}}"></script>
</head>

<body ng-controller="baseCtrl" ng-cloak>
    <div class="" ng-controller='bookingsCtrl' ng-init='initReceipt({{$booking_id}})'>
        @include('bookings.receipt_booking_angular')
    </div>
</body>


<script type="text/javascript">
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
</script>


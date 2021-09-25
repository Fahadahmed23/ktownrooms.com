<!doctype html>
<html lang="en" ng-app="ktown">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="csrf-token" content="{{ csrf_token() }}" />   
    <link rel="shortcut icon" href="https://www.ktownrooms.com/resources/assets/web/img/favicon.png" type="image/x-icon">
	<title>KTOWNROOMS</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/material/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/angular-material.min.css')}}">
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


   
	<style>
		input[type=checkbox][data-fouc], input[type=radio][data-fouc]{
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
        .dataTables_length{
            display: none;
        }
        .bg-pink-400{
            background-color: rgb(63 81 181 / 34%) !important;
        }

        [class*=bg-]:not(.bg-transparent):not(.bg-light):not(.bg-white):not(.bg-pink-800):not(.btn-outline):not(body) {
            color: #fff !important;
        }
        .bg-pink-800, .ribbon {
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
        /* .navbar a {
            color: #324148;
        } */
    </style>

</head>

<body class="sidebar-component-hidden" ng-controller="baseCtrl" ng-cloak>

   
    


	<!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
			<!-- Content area -->
           
            @yield('content')
			<!-- Footer -->
			<!-- /footer -->

		</div>
		<!-- /main content -->
	</div>	
        
</body>

<script type="text/javascript">
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
                                        scope.inventory.image = response.payload;
                                        break;
                                    default:
                                        break;
                                }
                            })

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
            $('.extension_us').mask('00000');
            $('.zip_us').mask('00000');
            $('.num3').mask('000');
            $('.num2').mask('00');
            $('.percent').mask("99.9%");
            $('.cnic').mask('00000-0000000-0');
            $('.cardnumber').mask('0000 0000 0000 0000');
            $('.cvc').mask('0000');
            $('.expiry_date').mask('00/00');
            $('.date_format').mask('39-19-0000');
            // $('.chequenumber').mask('00000000-0000000-00000000000000000-000');
            $('.cheque').mask('00000000');
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


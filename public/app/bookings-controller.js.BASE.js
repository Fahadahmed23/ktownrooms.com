app.controller('bookingsCtrl', function($scope, $rootScope, DTColumnDefBuilder, DTOptionsBuilder, $filter) {
    // variables
    $scope.cities = [];
    $scope.hotels = [];
    $scope.formType = "";
    $scope.booking = {};
    $scope.bookings = [];
    $scope.rooms = [];
    $scope.user = [];
    $scope.bookingDetail = {};
    $scope.start_date = moment(new Date()).format('MM/DD/YYYY');
    $scope.end_date = moment(new Date()).format('MM/DD/YYYY');
    $scope.optionsRadio = {};
    $scope.nBooking = {};
    $scope.payTyp = {};
    $scope.customer = {};
    $scope.promotion = {};
    $scope.tax_rate_id = 0;
    $scope.taxrates = [];
    $scope.selectedRoom = {};
    $scope.bookOccupant = {};
    $scope.inBooking = true;
    $scope.promo_applied = false;
    $scope.occu_form_type = "";
    $scope.occupant_key = 5000;
    $scope.email_regex = new RegExp("[a-z]([a-z.0-9]+)?@[a-z]([a-z0-9]+)?(.[a-z]([a-z0-9]+)?)+");

    $scope.searchCode = "";
    $scope.searchName = "";
    $scope.searchHotel = "";
    $scope.searchPhone = "";
    $scope.searchStatus = "";
    $scope.searchBookingDate = "";
    $scope.searchCheckIn = "";
    $scope.searchCheckOut = "";
    $scope.searchOccupants = "";
    $scope.required_occupants = 0;
    $scope.nights = 0;
    $scope.discount_amount = 0;

    $scope.statuses = [];

    $scope.hotel = {};

    // extend checkout
    $scope.extend = 1;

    $scope.paid_disabled = false;
    $scope.discount_disabled = false;
    $scope.status_disabled = false;
    $scope.can_checkout = false;
    $scope.lockdown = false;

    $scope.filteredHotels = [];

    // open service and complain
    $scope.redirect_url = "";

    $scope.clients = [];

    // $scope.channels = [
    //     'Walk-In',
    //     'On Call',
    //     'Email',
    //     'Phone'
    // ];

    // CNIC or Passport
    $scope.document_type = [
        { id: 1, name: 'CNIC' },
        { id: 2, name: 'Passport' }
    ];

    $scope.today = moment().format('YYYY-MM-DD');

    $scope.bulk_edit_occupants = false;

    $scope.inPrint = false;

    $scope.toStatus = "";

    // $scope.nBooking.customer.is_cnic = ;0

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0'<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([9]).notSortable(),
    ];

    // functions
    $scope.init = function() {
        $scope.getBookings();

        $('#startdate').pickadate('picker').set('min', (new moment()).format('MM/DD/YYYY'));
        $('#enddate').pickadate('picker').set('min', (new moment()).format('MM/DD/YYYY'));
    }

    $scope.incrementRoomOccupants = function(r) {
        if (r.hotel_room_category.max_allowed >= r.occupants + 1) {
            r.occupants++;
            $scope.required_occupants++;
        }

        $scope.calculateTotalAmount();
    }


    $scope.getRoomStatus = function(grs) {
        console.log(grs);
        switch (grs) {
            case 'Not Available':
                return 'badge badge-danger';
            case 'Open':
                return 'badge badge-success';
            case 'Booked':
                return 'badge badge-success';
        }
    }
    $scope.decrementRoomOccupants = function(r) {
        // check whether it can be deleted or not
        if ($scope.required_occupants - 1 == $scope.nBooking.booking_occupants.length) {
            bootbox.dialog({
                closeButton: false,
                title: "Error",
                message: 'Please remove an occupant first',
                buttons: {
                    success: {
                        label: "Ok",
                        callback: function() {
                            return;
                        }
                    }
                }
            });
            return;
        }

        if (r.occupants - 1 > 0) {
            r.occupants--;
            $scope.required_occupants--;
        }
        $scope.calculateTotalAmount();
    }


    $scope.calculateTotalAmount = function() {
        let a = 0; // amount
        let s = moment($scope.start_date, "MM/DD/YYYY"); // start date in moment instance
        let e = moment($scope.end_date, "MM/DD/YYYY"); // end date in moment instance
        let n = e.diff(s, "days");
        n = n > 0 ? n : 1;

        $scope.nBooking.invoice.total = 0;

        $scope.nights = n;

        if ($scope.nBooking.invoice.per_night == 1) {
            $scope.nBooking.invoice.discount_amount = $scope.discount_amount * $scope.nights;
            $scope.nBooking.invoice.discount_per_night = $scope.discount_amount;
        } else {
            $scope.nBooking.invoice.discount_amount = $scope.discount_amount;
        }

        for (let i = 0; i < $scope.nBooking.rooms.length; i++) {
            a = 0;
            a += n * $scope.nBooking.rooms[i].RoomCharges;

            if ($scope.nBooking.rooms[i].occupants > $scope.nBooking.rooms[i].hotel_room_category.allowed) {
                a += n * $scope.nBooking.rooms[i].hotel_room_category.additional_guest_charges * ($scope.nBooking.rooms[i].occupants - $scope.nBooking.rooms[i].hotel_room_category.allowed);
            }

            $scope.nBooking.rooms[i].sub_total = a;
            $scope.nBooking.invoice.total += a;
        }
        $scope.nBooking.end_date = moment($scope.end_date).format("YYYY-MM-DD");

        $scope.applyDiscount();
        $scope.applyTax();
        
        $scope.addServicesAmount();

        $scope.nBooking.invoice.net_total = parseInt($scope.nBooking.invoice.net_total);
        $scope.max_payment = $scope.nBooking.invoice.net_total;
    }

    $scope.addServicesAmount = function() {
        if ($scope.nBooking.services) {
            for (i = 0; i < $scope.nBooking.services.length; i++) {
                $scope.nBooking.invoice.net_total += $scope.nBooking.services[i].service_charges;
                $scope.nBooking.invoice.total += $scope.nBooking.services[i].service_charges;
            }
        }
    }

    $scope.showOccupantsModal = function() {
        $scope.bulk_edit_occupants = false;

        $scope.occupant_form.$setPristine();
        $scope.occupant_form.$setUntouched();

        if ($scope.lockdown) {
            return;
        }

        // calculate required occupants
        $scope.required_occupants = 0;
        if ($scope.nBooking.rooms.length > 0) {
            for (let i = 0; i < $scope.nBooking.rooms.length; i++) {
                $scope.required_occupants += $scope.nBooking.rooms[i].occupants;
            }
        } else {
            bootbox.dialog({
                closeButton: false,
                title: "Error",
                message: 'Please select room(s) first',
                buttons: {
                    success: {
                        label: "Ok",
                        callback: function() {
                            return
                        }
                    }
                }
            });
            return;
        }

        if ($scope.nBooking.booking_occupants.length < $scope.required_occupants - 1) {
            $scope.bookOccupant = {
                Over18: 0
            };

            $('.over_18_required').hide();
            $('.CNIC_required').hide();
            $('.Passport_required').hide();

            $scope.occu_form_type = "create";

            $('#addOccupant').modal();
        } else {
            bootbox.alert('You can only add ' + ($scope.required_occupants - 1) + ' occupants');
        }
    }
    $scope.showOccupantsModalEdit = function(nOccupant, tf) {
        if (tf) {
            $scope.bulk_edit_occupants = false;
        }

        $scope.occupant_form.$setPristine();
        $scope.occupant_form.$setUntouched();

        if ($scope.lockdown) {
            return;
        }
        $scope.occu_form_type = "edit";

        $scope.bookOccupant = {
            id: nOccupant.id,
            FirstName: nOccupant.FirstName,
            LastName: nOccupant.LastName,
            Over18: nOccupant.Over18,
        };

        if ($scope.bookOccupant.Over18 == '1') {
            if (nOccupant.CNIC && nOccupant.CNIC.trim().length > 0) {
                $scope.bookOccupant.d_typ = 1;
                $scope.bookOccupant.CNIC = nOccupant.CNIC;
                $('.CNIC_required').show();
            }

            if (nOccupant.Passport && nOccupant.Passport.trim().length > 0) {
                $scope.bookOccupant.d_typ = 2;
                $scope.bookOccupant.Passport = nOccupant.Passport;
                $('.Passport_required').show();
            }
        } else {
            $('.CNIC_required').hide();
            $('.Passport_required').hide();
        }

        $('#addOccupant').modal();
    }
    $scope.showOccupants = function() {
        if ($scope.bulk_edit_occupants) {
            $('#addOccupant').modal('hide');
            $('#mediaList').show();
            $scope.bulk_edit_occupants = false;
            return;
        }

        $scope.occupant_form.$submitted = true;

        if (!$scope.occupant_form.$valid) {
            return;
        }

        // if (!$scope.occupant_form.$valid) {
        //     if ($scope.occupant_form.occupantFirstName.$invalid || $scope.occupant_form.occupantLastName.$invalid) {
        //         return;
        //     }
        //     if ($scope.occupant_form.occupantCNIC.$invalid && $scope.occupant_form.occupantPassport.$invalid) {
        //         return;
        //     }
        // }

        if ($scope.bookOccupant.Over18 == '1' && $scope.bookOccupant.CNIC) {
            let found;
            if ($scope.occu_form_type == 'create') {
                // find the new NIC in existing NICs
                found = $scope.nBooking.booking_occupants.find((o) => o.CNIC == $scope.bookOccupant.CNIC || ($scope.nBooking.customer.CNIC && o.CNIC == $scope.nBooking.customer.CNIC));
            } else {
                found = $scope.nBooking.booking_occupants.find((o) => (o.CNIC == $scope.bookOccupant.CNIC && o.id != $scope.bookOccupant.id) || ($scope.nBooking.customer.CNIC && o.CNIC == $scope.nBooking.customer.CNIC));
            }

            if (found) {
                bootbox.dialog({
                    closeButton: false,
                    title: "Error",
                    message: 'CNIC number should be unique for each occupant',
                    buttons: {
                        success: {
                            label: "Ok",
                            callback: function() {
                                return
                            }
                        }
                    }
                });
                return;
            }
        }

        if ($scope.bookOccupant.Over18 == '1' && $scope.bookOccupant.Passport) {
            let found;
            if ($scope.occu_form_type == 'create') {
                // find the new Passport in existing Passports
                found = $scope.nBooking.booking_occupants.find((o) => o.Passport == $scope.bookOccupant.Passport);
            } else {
                found = $scope.nBooking.booking_occupants.find((o) => (o.CPassportNIC == $scope.bookOccupant.Passport && o.id != $scope.bookOccupant.id));
            }

            if (found) {
                bootbox.dialog({
                    closeButton: false,
                    title: "Error",
                    message: 'CNIC number should be unique for each occupant',
                    buttons: {
                        success: {
                            label: "Ok",
                            callback: function() {
                                return
                            }
                        }
                    }
                });
                return;
            }

            console.log(found);
        }


        // let form = $("#ocupantform");
        // console.log(form.valid());
        // if (form.valid() == false) {
        //     return;
        // }

        if ($scope.occu_form_type == "create") {
            $scope.bookOccupant.id = $scope.occupant_key++;
            $scope.nBooking.booking_occupants.push($scope.bookOccupant);
        } else {
            $scope.nBooking.booking_occupants = $scope.nBooking.booking_occupants.map((o) => o.id == $scope.bookOccupant.id ? $scope.bookOccupant : o);
        }

        // $scope.nBooking.booking_occupants = [];

        $scope.bookOccupant = {};
        // console.log("here");
        $('#addOccupant').modal('hide');
        $('#mediaList').show();
    }

    $scope.changeCheckInDate = function() {
        $scope.changeStartDate();

        $scope.calculateTotalAmount();

        $scope.nBooking.start_date = moment($scope.start_date).format("YYYY-MM-DD");
    }

    $scope.checkCustAvl = function(s) {
        if (s == 'e') {
            if (!$scope.myForm.Email.$valid) {
                return;
            }

            if (!$scope.email_regex.test($scope.nBooking.customer.Email)) {
                return;
            }
        }

        if (s == 'c') {
            if (!$scope.myForm.CNIC.$valid) {
                return;
            }

            let found;

            // check whether the customer CNIC is unique or not
            if ($scope.nBooking.booking_occupants.length > 0) {
                found = $scope.nBooking.booking_occupants.find((o) => o.CNIC == $scope.nBooking.customer.CNIC);

                if (found) {
                    bootbox.dialog({
                        closeButton: false,
                        title: "Error",
                        message: 'CNIC number should be unique for each occupant. This CNIC is already used in occupants.',
                        buttons: {
                            success: {
                                label: "Ok",
                                callback: function() {
                                    return
                                }
                            }
                        }
                    });
                    return;
                }
            }
        }

        // make plain ajax request
        $.post('findCustomer', {
            'Email': $scope.nBooking.customer.Email,
            'CNIC': $scope.nBooking.customer.CNIC,
            '_token': $("meta[name='csrf-token']").attr('content')
        }).done(function(response) {
            if (response.success) {
                $scope.nBooking.customer = response.customer;
                // $scope.nBooking.customer.Phone = $scope.nBooking.customer.Phone.substr(0, 4) + '-' + $scope.nBooking.customer.Phone.substr(4)
                $scope.nBooking.customer.created_at = moment($scope.nBooking.customer.created_at).format("MM/DD/YYYY");
                $scope.nBooking.customer.LatestBooking = moment($scope.nBooking.customer.LatestBooking).format("MM/DD/YYYY");

                toastr.success(response.message);

                $('.customercard').show();
                $('.customerinfofieldset').hide();

                $scope.$apply();
            } else {
                // bootbox.alert("Customer Not Found");
            }
        }).fail(function(e) {

        });
        return false;
    }

    $scope.showSearch = function() {
        $('#ANR-filter').show('slow');
        $scope.formType = "create";
        $scope.hideTable();

        $('.customercard').hide();
        $('.customerinfofieldset').show();
        $scope.bookingFrm.$setPristine();
        $scope.bookingFrm.$setUntouched();
    }

    $scope.hideSearch = function() {
        $('#ANR-filter').hide('slow');
        $scope.hideBookForm();
        $scope.newBooking();
        $scope.showTable();
        $scope.hideRooms();

        $scope.start_date = $scope.end_date = moment(new Date()).format('MM/DD/YYYY');
    }

    $scope.createStatuses = function() {
        switch ($scope.nBooking.status) {
            case "Confirmed":
                $scope.statuses = [
                    'Confirmed',
                ];

                if ($scope.nBooking.id) {
                    $scope.statuses.push('Cancelled');
                }
                break;

            case "Pending":
                $scope.statuses = [
                    'Pending',
                    'Confirmed',
                ];

                if ($scope.nBooking.id) {
                    $scope.statuses.push('Cancelled');
                }
                break;

            case "CheckedIn":
                $scope.statuses = [];
                break;
            default:
                break;
        }
    }

    $scope.showBooking = function() {
        $scope.show_discount = true;

        for (i = 0; i < $scope.nBooking.rooms.length; i++) {
            if ($scope.nBooking.rooms[i].pivot.room_charges_onbooking != $scope.nBooking.rooms[i].pivot.room_charges) {
                $scope.show_discount = false;
                break;
            }
        }
        // create statuses
        // $scope.createStatuses();
        // if ($scope.lockdown) {
        //     $scope.statuses.push('Pending');
        // }

        if ($scope.nBooking.invoice.per_night == 1) {
            $scope.discount_amount = $scope.nBooking.invoice.discount_per_night;
        } else {
            $scope.discount_amount = $scope.nBooking.invoice.discount_amount;
        }

        $scope.formType = "edit";
        $scope.bookingFrm.$setPristine();
        $scope.bookingFrm.$setUntouched();

        if ($scope.nBooking.status == "Cancelled" || $scope.nBooking.status == 'CheckedOut') {
            bootbox.alert('You cannot edit booking which is ' + $scope.nBooking.status + '.');
            return;
        }

        if ($scope.nBooking.promotion_id != null) {
            $('#promo_button').hide();
        }

        $scope.tax_rate = angular.copy($scope.nBooking.tax_rate);
        $scope.nBooking.cheque_no = $scope.nBooking.invoice.payment_mode_details;

        // set payment type
        for (let i = 0; i < $scope.paymenttypes.length; i++) {
            if ($scope.paymenttypes[i].id == $scope.nBooking.invoice.payment_mode_id) {
                $scope.nBooking.payTyp = $scope.paymenttypes[i];
                break;
            }
        }

        // set tax
        for (let i = 0; i < $scope.taxrates.length; i++) {
            if ($scope.taxrates[i].id == $scope.nBooking.tax_rate_id) {
                $scope.nBooking.tax_rate_id = $scope.taxrates[i].id;
                $scope.tax_rate = angular.copy($scope.taxrates[i]);
                $scope.TaxValue = $scope.tax_rate.TaxValue;
                break;
            }
        }

        $scope.nBooking.start_date = $scope.nBooking.BookingFrom;
        $scope.nBooking.end_date = $scope.nBooking.BookingTo;

        $scope.start_date = moment($scope.nBooking.start_date).format("MM/DD/YYYY");
        $scope.end_date = moment($scope.nBooking.end_date).format("MM/DD/YYYY");

        $scope.nBooking.occupants = $scope.nBooking.no_occupants;
        $scope.nBooking.booking_occupants = $scope.nBooking.booking_occupants.filter((o) => o.CNIC != $scope.nBooking.customer.CNIC);
        $scope.nBooking.promo = $scope.nBooking.promotion;

        $scope.nBooking.city_id = $scope.nBooking.hotel.city_id;

        if ($scope.nBooking.promotion) {
            $scope.promotion = $scope.nBooking.promotion;
        } else {
            $scope.promotion = {};
        }

        // load customer from invoice
        $scope.nBooking.customer.FirstName = $scope.nBooking.invoice.customer_first_name;
        $scope.nBooking.customer.LastName = $scope.nBooking.invoice.customer_last_name;
        $scope.nBooking.customer.Email = $scope.nBooking.invoice.customer_email;
        $scope.nBooking.customer.Phone = $scope.nBooking.invoice.customer_phone;
        $scope.nBooking.customer.created_at = new Date($scope.nBooking.customer.created_at);
        $scope.nBooking.customer.LatestBooking = new Date($scope.nBooking.customer.LatestBooking);

        // tax
        if ($scope.nBooking.tax_rate) {
            $scope.nBooking.tax_rate.Tax = $scope.nBooking.invoice.tax_name;
            $scope.nBooking.TaxValue = $scope.nBooking.invoice.tax_rate;
        } else {
            $scope.nBooking.tax_rate = {};
        }

        $('.customercard').show();
        // $scope.nBooking.customer.Phone = $scope.nBooking.customer.Phone.substr(0, 4) + '-' + $scope.nBooking.customer.Phone.substr(4)
        $('.customerinfofieldset').hide();
        $scope.hideFilter();
        $scope.showBookForm();
        // set search form
        $scope.setSearchForm();
        $('#ANR-filter').show('slow');
        // occupants should be out of pivot
        for (let i = 0; i < $scope.nBooking.rooms.length; i++) {
            $scope.nBooking.rooms[i].occupants = $scope.nBooking.rooms[i].pivot.occupants;
            $scope.nBooking.rooms[i].room_charges_onbooking = $scope.nBooking.rooms[i].pivot.room_charges_onbooking;
        }

        // $scope.calculateTotalAmount();
        $scope.disableControls();

        // show occupants
        $scope.required_occupants = $scope.nBooking.no_occupants;

        $scope.hotel = $scope.hotels.filter((h) => h.id == $scope.nBooking.hotel.id);
        $scope.hotel = $scope.hotel[0];

        $scope.can_extend = $scope.nBooking.status == 'CheckedIn' ? true : false;


        // if ($scope.nBooking.status == 'Confirmed' || $scope.nBooking.status == 'Pending') {
        //     $scope.renderCheckInDate();
        // }
    }

    $scope.changeStartDate = function() {
        let m = moment($scope.start_date).format('MM/DD/YYYY');
        $('.enddate').pickadate('picker').set('min', m);

        if (moment(m).diff(moment($scope.end_date), 'days') > 0)
            $scope.end_date = m;
    }

    $scope.changeEndDate = function() {
        let m = moment($scope.end_date).format('MM/DD/YYYY');
        $('.startdate').pickadate('picker').set('max', m);

        if (moment($scope.start_date).diff(moment(m)) > 0)
            $scope.start_date = m;
    }

    $scope.renderCheckInDate = function() {
        $('#checkin_date').pickadate('picker').set('min', moment().format('MM/DD/YYYY'));

        $scope.changeEndDate();
    }

    $scope.editBooking = function(b) {
        let abc = $scope.bookings.find((bk) => bk.id == b);
        $scope.inBooking = true;

        // Get booking from server
        $scope.ajaxGet('bookings/find/' + b, {}, true)
            .then(function(response) {
                if (response.success) {
                    if (response.msg.trim().length > 0) {
                        toastr.info(response.msg);
                    }

                    $scope.nBooking = response.booking;
                    $scope.old_status = $scope.nBooking.status;
                    // if ($scope.toStatus == 'CheckedIn') {
                    //     $scope.nBooking.status = 'CheckedIn';
                    //     $scope.toStatus = 'inTransition';
                    // }

                    if (response.lockdown) {
                        $scope.imposeLockdown();
                        // $scope.showLockdownMessage();
                    } else {
                        $scope.lockdown = false;
                    }

                    $scope.showBooking();
                } else {
                    console.log(response);
                }
            }).catch(function(e) {
                console.log(e);
            });

        return;
    }

    $scope.showLockdownMessage = function() {
        let title = "Discount Limit Exceeds";
        let text = "Discount on this booking (" + $scope.nBooking.invoice.discount_amount + ") exceeds your discount limit (" + $scope.user.max_allowed_discount + "). A request for approval was sent to your supervisor.";

        toastr.info(title, text, { timeOut: 0 });
        $scope.nBooking.discount_request = {
            status: "Pending"
        }
    }

    $scope.setSearchForm = function() {
        $scope.nBooking.no_rooms = $scope.nBooking.rooms.length;
        $scope.rooms = [];
    }

    $scope.applyPromo = function() {
        $scope.ajaxPost('searchPromotion', {
            'code': $scope.nBooking.promotion.Code
        }, false).then(function(response) {
            // console.log(response.promotion);
            if (response.promotion.length > 0) {
                $scope.promotion = response.promotion[0];
                $scope.nBooking.promo = response.promotion[0];
                $('#promo_button').hide();
                console.log(response);
                // calculate amount
                $scope.applyPromotion();
            }
        }).catch(function(e) {
            console.log(e);
            return false;
        });

        return false;
    }

    $scope.cheque = function() {
        if ($scope.nBooking.payTyp.id == 2) {
            $('.chequerow').show();
        } else {
            $('.chequerow').hide();
        }
    }

    $scope.applyPromotion = function() {
        if ($scope.promotion.IsPercentage == 1) {
            $scope.nBooking.invoice.discount_amount = $scope.nBooking.invoice.total * ($scope.promotion.DiscountValue / 100);
        } else {
            $scope.nBooking.invoice.discount_amount = $scope.promotion.DiscountValue
        }

        $scope.nBooking.invoice.net_total = $scope.nBooking.invoice.net_total - $scope.nBooking.invoice.discount_amount;
    }

    $scope.applyTax = function() {
        // subtotal is replacement of $scope.nBooking.invoice.total;
        let subtotal = $scope.nBooking.invoice.total - $scope.nBooking.invoice.discount_amount;

        if ($scope.nBooking.tax_rate_id == 0) {
            $scope.nBooking.invoice.tax_charges = 0;
            $scope.nBooking.invoice.tax_rate = 0;
            $scope.nBooking.invoice.net_total = subtotal;
            
            return;
        }

        $scope.nBooking.invoice.tax_charges = (parseFloat($scope.tax_rate.TaxValue) / 100) * subtotal;
        $scope.nBooking.invoice.net_total = parseFloat(subtotal) + parseFloat($scope.nBooking.invoice.tax_charges);
        $scope.nBooking.tax_rate_id = $scope.tax_rate.id;
        $scope.nBooking.invoice.tax_rate = $scope.tax_rate.TaxValue;

        // recalculate discount also
        if ($scope.promotion.id) {
            // $scope.applyPromotion();
        }
    }

    $scope.applyDiscount = function() {
        if ($scope.nBooking.discount_request) {
            $scope.nBooking.invoice.net_total -= $scope.nBooking.invoice.discount_amount;
            return;
        }

        if ($scope.user.is_supervisor) {
            $scope.user.can_give_discount = true;
            $scope.user.max_allowed_discount = $scope.nBooking.invoice.total;
        }

        if ($scope.user.can_give_discount) {
            if ($scope.user.max_allowed_discount) {
                if (parseInt($scope.nBooking.invoice.discount_amount) > parseInt($scope.nBooking.invoice.total)) {
                    toastr.info('Discount cannot exceed booking charges (i.e., ' + $filter('currency')($scope.nBooking.invoice.total, 'Rs. ', 0) + ')');
                    $scope.nBooking.invoice.discount_amount = $scope.nBooking.invoice.total;
                    $scope.nBooking.invoice.paid = $scope.user.is_supervisor ? $scope.nBooking.invoice.paid : 0;
                    $scope.paid_disabled = true && !$scope.user.is_supervisor;
                    $scope.nBooking.status = $scope.user.is_supervisor ? $scope.nBooking.status : "Pending";
                    $scope.status_disabled = true && !$scope.user.is_supervisor;
                } else if (parseInt($scope.nBooking.invoice.discount_amount) > parseInt($scope.user.max_allowed_discount)) {
                    $scope.nBooking.invoice.paid = $scope.user.is_supervisor ? $scope.nBooking.invoice.paid : 0;
                    $scope.paid_disabled = true && !$scope.user.is_supervisor;
                    $scope.nBooking.status = $scope.user.is_supervisor ? $scope.nBooking.status : "Pending";
                    $scope.status_disabled = true && !$scope.user.is_supervisor;
                } else {
                    $scope.status_disabled = false;
                    $scope.paid_disabled = false;
                }

                $scope.nBooking.invoice.net_total -= $scope.nBooking.invoice.discount_amount;
            }
        }

        if ($scope.user.is_frontdesk && $scope.nBooking.status == "Pending" && $scope.paid_disabled) {
            if ($scope.statuses.findIndex((s) => s == "Pending") == -1)
                $scope.statuses.push("Pending");
        } else if ($scope.user.is_frontdesk) {
            $scope.statuses = $scope.statuses.filter((t) => t != "Pending");
            $scope.nBooking.status = $scope.statuses[0];
        }
    }

    $scope.saveForm = function() {
        if ($scope.is_partial == 1) {
            // paid = 1
            $scope.nBooking.invoice.paid = 1;
            $scope.nBooking.invoice.payment_amount = $scope.partial_payment;
            $scope.nBooking.invoice.payment_type_id = $scope.partial_payment_typ.id;
            $scope.nBooking.invoice.payment_type_name = $scope.partial_payment_typ.PaymentMode;
            if ($scope.nBooking.invoice.payment_type_name == 'Cheque') {
                $scope.nBooking.invoice.payment_details = $scope.partial_payment_cheque;
            }
        }

        $scope.nBooking.hotel_id = $scope.hotel.id;

        if ($scope.user.is_frontdesk) {
            $scope.nBooking.hotel_id = $scope.hotels[0].id;
        }

        $scope.nBooking.tax = $scope.tax_rate;

        let url = "bookings";
        // url += $scope.formType == "edit" ? "/" + $scope.nBooking.id : "";

        $scope.nBooking.customer.ph = $scope.nBooking.customer.Phone;
        // $scope.nBooking.customer.Phone = $scope.nBooking.customer.Phone.replace('-', '');

        $scope.nBooking.occupants = $scope.required_occupants;

        $scope.ajaxPost(url, { 'booking': $scope.nBooking, 'formType': $scope.formType }, false).then(function(response) {
            if (response.success) {
                if ($scope.user.is_frontdesk) {
                    $('#invoiceBox').modal('hide');
                    $scope.loadFrontdesk();
                }

                if (response.lockdown) {
                    $scope.imposeLockdown();
                    $scope.nBooking.id = response.booking.id;
                    $scope.lockdown = true;

                    // hide invoice
                    $('#invoiceBox').modal('hide');

                    // show toaster for discount request
                    $scope.showLockdownMessage();
                    return;
                }

                response.booking.BookingDate = new Date(response.booking.BookingDate);

                if ($scope.formType == 'create') {
                    $scope.bookings.push(response.booking);
                } else {
                    // $scope.bookings = $scope.bookings.map((booking) => booking.id == response.booking.id ? response.booking : booking)
                    $scope.init();
                    // $scope.$apply();
                }

                $scope.afterSaveOrEdit();
            }


        }).catch(function(e) {
            console.log(e)
                // $scope.nBooking.customer.Phone = $scope.nBooking.customer.ph;
        })
    }

    $scope.imposeLockdown = function() {
        // disable all controls (inputs, buttons) except cancel button and refresh button
        $scope.lockdown = true;
    }

    $scope.refresh_booking = function() {
        let id = $scope.nBooking.id;

        // refresh current booking
        // make a pending badge
    }

    $scope.afterSaveOrEdit = function() {
        $scope.toStatus = '';
        $scope.is_partial = 0;

        if ($scope.user.is_frontdesk) {
            $('#ANR-filter').show('slow');
            $('.bookingForm').hide('slow');
            $('rooms-available').show('slow');
            $('#statusChange').modal('hide');
            $scope.loadFrontdesk();
            return;
        }

        $scope.filteredHotels = [];
        $scope.lockdown = false;
        $('#ANR-filter').hide('slow');
        $('.bookingForm').hide('slow');
        $scope.hideBookDetailRBox('slow');
        $scope.showTable();
        // $('.bookingTable').show('slow');
        $('#invoiceBox').modal('hide');
        $scope.nBooking = {};
        $scope.nBooking.occupants = 1;
        $scope.nBooking.no_rooms = 1;

        $scope.start_date = $scope.end_date = moment(new Date()).format('MM/DD/YYYY');
        $scope.inBooking = false;

        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();
        document.getElementById('paymentForm').reset();
    }

    $scope.showInvoice = function(bookingInvoice) {

        if ($scope.is_partial == 1) {
            if (!$scope.paymentIsValid()) {
                return;
            }
        }

        if ($scope.lockdown) {
            return;
        }

        if ($scope.nBooking.status == 'Cancelled') {

            $scope.cancelBooking($scope.nBooking);
            // $scope.afterSaveOrEdit();
            return;
        }

        if ($scope.nBooking.status == 'CheckedIn') {
            $scope.required_occupants = 0;
            if ($scope.nBooking.rooms.length > 0) {
                for (let i = 0; i < $scope.nBooking.rooms.length; i++) {
                    $scope.required_occupants += $scope.nBooking.rooms[i].occupants;
                }
            }

            if ($scope.required_occupants != $scope.nBooking.booking_occupants.length + 1) {
                bootbox.dialog({
                    closeButton: false,
                    title: "Error",
                    message: 'You are required to enter details of ' + ($scope.required_occupants - 1) + ' occupants',
                    buttons: {
                        success: {
                            label: "Ok",
                            callback: function() {
                                return
                            }
                        }
                    }
                });
                return;
            }
        }

        // at least 1 or more room(s) should be selected
        if ($scope.nBooking.rooms.length == 0) {
            // bootbox.alert('Please Select at least one room');
            bootbox.dialog({
                closeButton: false,
                title: "Error",
                message: 'Please Select at least one room',
                buttons: {
                    success: {
                        label: "Ok",
                        callback: function() {
                            // show rooms
                            // $scope.showRooms();
                            // $scope.hideBookForm()
                            return
                        }
                    }
                }
            });
            return;
        }

        // cannot book if it is not a corporate client and paid is false
        // if (!$scope.nBooking.invoice.is_corporate && $scope.nBooking.status == 'CheckedIn' && $scope.nBooking.invoice.paid == 0) {
        //     bootbox.dialog({
        //         closeButton: false,
        //         title: "Error",
        //         message: 'You cannot Check-In without payment',
        //         buttons: {
        //             success: {
        //                 label: "Ok",
        //                 callback: function() {
        //                     // show rooms
        //                     // $scope.showRooms();
        //                     // $scope.hideBookForm()
        //                     return
        //                 }
        //             }
        //         }
        //     });
        //     return;
        // }

        // run customer validation

        $scope.nBooking.customer.Phone = iti.getNumber();
        $scope.nBooking.customer.iso = iti.selectedCountryData.iso2;
        console.log($scope.nBooking);

        $scope.myForm.$submitted = true;
        if (!$scope.myForm.$valid) {
            return;
        }

        $('#invoiceBox').modal('show');
        $scope.Invoice = angular.copy(bookingInvoice);
        console.log($scope.Invoice);
    }

    $scope.searchRooms = function() {
        // $scope.filteredHotels = [];

        $scope.bookingFrm.$submitted = true;

        if (!$scope.bookingFrm.$valid) {
            return;
        }

        $scope.getRooms();
    }

    $scope.getRooms = function() {
        $scope.nBooking.start_date = moment($scope.start_date).format("YYYY-MM-DD");
        $scope.nBooking.end_date = moment($scope.end_date).format("YYYY-MM-DD");

        $scope.ajaxPost('searchRooms', $scope.nBooking, false)
            .then(function(response) {
                $scope.rooms = response.rooms;
                // if ($scope.user.is_frontdesk) {
                $scope.breakdown = response.breakdown;
                // }

                if ($scope.in_room_dashboard) {
                    $(".show-rooms").show();
                    for (let i = 0; i < $scope.rooms.length; i++) {
                        if ($scope.rooms[i].st.name == "Booked") {
                            $scope.total_reserved++;
                        }
                        // $scope.booked_room = rst.filter((r) => r.name == "Reserved");
                    }
                }

                if ($scope.rooms.length > 0) {
                    $scope.showRooms();
                    $scope.hideTable();
                    $scope.nBooking.rooms = [];
                    $scope.nBooking.total = 0;
                    $('.selected-rm-detail').hide();
                    $('.room-container').removeClass('col-lg-10').addClass('col-lg-12');

                    // if ($scope.user.is_frontdesk) {
                    //     $scope.newBooking();
                    // }
                } else {
                    bootbox.dialog({
                        closeButton: false,
                        title: "Info",
                        message: 'No rooms found',
                        buttons: {
                            success: {
                                label: "Ok",
                                callback: function() {
                                    return;
                                }
                            }
                        }
                    });
                    return;
                }
            }).catch(function(e) {
                console.log(e)
            })
    }

    $scope.newBooking = function() {
        $scope.show_discount = true;
        $scope.discount_amount = 0;
        $scope.nBooking = {};

        $scope.can_checkout = false;
        $scope.can_extend = false;

        $scope.lockdown = false;
        $scope.nBooking.formType = "create";
        // $scope.nBooking.hotel.id = null;

        $scope.nBooking.invoice = {
            total: 0,
            tax_rate: 0,
            tax_charges: 0,
            discount_amount: 0,
            paid: 0,
            per_night: 0,
            discount_per_night: 0,
            payment_amount: 0
        };

        $scope.nBooking.payTyp = $scope.paymenttypes[0];

        $scope.tax_rate_id = 0;
        $scope.nBooking.tax_rate_id = 0;
        $scope.tax_rate = 0;
        $scope.TaxValue = 0;

        // let is_break = 0;
        // for (let i = 0; i < $scope.taxrates.length; i++) {
        //     if ($scope.taxrates[i].IsDefault == 1) {
        //         $scope.nBooking.tax_rate_id = $scope.taxrates[i].id;
        //         $scope.tax_rate = angular.copy($scope.taxrates[i]);
        //         $scope.TaxValue = $scope.tax_rate.TaxValue;
        //         is_break = 1;
        //         break;
        //     }
        // }

        // if (is_break == 0) {
        //     $scope.nBooking.tax_rate_id = $scope.taxrates[0].id;
        //     $scope.tax_rate = angular.copy($scope.taxrates[0]);
        //     $scope.TaxValue = $scope.tax_rate.TaxValue;
        // }
        $scope.nBooking.customer = {};
        $scope.nBooking.customer.is_cnic = 1;
        // return;

        $scope.nBooking.booking_occupants = [];
        $scope.rooms = [];
        $('#promo_button').show();
        $scope.nBooking.promotion = {};
        $scope.nBooking.occupants = 1;
        $scope.nBooking.no_rooms = 1;
        $scope.nBooking.rooms = [];
        $scope.promotion = {};

        // $scope.statuses = [
        //     'Pending',
        //     'Confirmed'
        // ];

        if (!$scope.user.is_frontdesk) {
            $scope.nBooking.status = 'Pending';
        } else {
            $scope.nBooking.status = 'Confirmed';
        }

        if ($scope.user.is_frontdesk) {
            $scope.nBooking.hotel = {
                id: $scope.hotels[0].id
            }
            $scope.nBooking.city_id = $scope.cities[0].id;
        }

        $scope.nBooking.channel = 'Walk-In';
        $scope.nBooking.invoice.is_corporate = 0;

        $scope.enableControls();
        $scope.inBooking = true;

        $scope.is_partial = 0;

        $scope.partial_payment = 0;
        $scope.partial_payment_typ = $scope.paymenttypes[0];
        $scope.partial_payment_cheque = "";
        $('.ppCheque').hide();

        if ($scope.user.is_frontdesk) {
            $scope.nBooking.hotel = $scope.hotels[0].id;
            $scope.hotel = $scope.hotels[0];

            $scope.changeHotel();
        }
    }

    $scope.getBookings = function() {
        $scope.ajaxGet('getBookings', {}, true)
            .then(function(response) {
                $scope.bookings = response.bookings;
                $scope.paymenttypes = response.paymenttypes;
                $scope.cities = response.cities;
                $scope.hotels = response.hotels;
                $scope.taxrates = response.taxrates;
                $scope.user = response.user;
                $scope.clients = response.clients;
                $scope.channels = response.channels;
                $scope.nationalities = response.nationalities;
                $scope.user_discount_limit = $scope.user.max_allowed_discount;

                for (let i = 0; i < $scope.bookings.length; i++) {
                    $scope.bookings[i].BookingDate = moment($scope.bookings[i].BookingDate).format('MM/DD/YYYY');
                    $scope.bookings[i].BookingFrom = moment($scope.bookings[i].BookingFrom).format('MM/DD/YYYY');
                    $scope.bookings[i].BookingTo = moment($scope.bookings[i].BookingTo).format('MM/DD/YYYY');
                }
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.showBookDetailRBox = function(b) {
        $scope.formType = 'view';

        $scope.bookingDetail = {};
        $scope.findBooking(b, function() {
            $scope.bookingDetail = $scope.fBooking;
            $('.BookDetailRBox').show('slow');
            $('#bookings-table').removeClass('col-lg-12').addClass('col-lg-8');
            $scope.hideFilter();

            $scope.bookingDetail.status_history = $scope.bookingDetail.status_history.map(function(h) {
                h.status_date = moment(h.status_date).format('MM/DD/YYYY hh:mm:ss A');
                return h;
            })
        });
    }

    $scope.prepareStatusHistory = function() {
        let status_history = [];

        if ($scope.bookingDetail.status_history) {
            status_history = $scope.bookingDetail.status_history.split(',').map(function(h) {
                let s = h.split('.');

                return {
                    status: s[0],
                    timestamp: s[1]
                }
            });
        }

        $scope.bookingDetail.status_table = status_history;
    }

    $scope.hideBookDetailRBox = function() {
        $('.BookDetailRBox').hide();
        $('#bookings-table').removeClass('col-lg-8').addClass('col-lg-12');
    }

    $scope.showBookForm = function() {
        $scope.createStatuses();
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();
        // calculate required occupants
        $scope.required_occupants = 0;

        for (let i = 0; i < $scope.nBooking.rooms.length; i++) {
            // if (i < $scope.nBooking.rooms.length - 1) {
            //     $scope.nBooking.rooms[i].occupants = $scope.nBooking.rooms[i].hotel_room_category.max_allowed;
            // }
            $scope.required_occupants += $scope.nBooking.rooms[i].occupants;
        }

        $('.bookingForm').show('slow', function() {
            $('[data-popup="popover"]').popover();
        });
        $('.BookDetailRBox').hide();
        $scope.hideTable();

        $('#rooms-available').hide();
        $('#ANR-filter').hide('slow');

        // if ($scope.formType == "create") {
        $scope.nBooking.invoice.net_total = $scope.nBooking.invoice.total;

        // apply taxes
        $scope.nBooking.invoice.tax_charges = (parseFloat($scope.TaxValue) / 100) * $scope.nBooking.invoice.total;
        $scope.nBooking.invoice.net_total += $scope.nBooking.invoice.tax_charges;

        // $scope.calculateTotalAmount();

        if ($scope.formType == 'create') {
            $('.customerinfofieldset').show();
        }

        // if today's date is the checkin date of the booking there should be a checkin status available
        if (!$scope.lockdown && $scope.nBooking.start_date == $scope.today || $scope.nBooking.status == 'CheckedIn') {
            $scope.statuses.push('CheckedIn');
        }

        $scope.calculateTotalAmount();
    }

    $scope.hideBookForm = function() {
        $('.bookingForm').hide();
        $('#ANR-filter').hide();
        $scope.newBooking();
        $('#bookings-table').removeClass('col-lg-8').addClass('col-lg-12');
        $scope.showTable();

        $scope.start_date = $scope.end_date = moment(new Date()).format('MM/DD/YYYY');
    }

    // $scope.changePayType = function() {
    //     if ($scope.payTyp.id == 1) {
    //         console.log($scope.payTyp);
    //         $('.chequerow').hide('fast');
    //         $('.creditrow').hide('fast');
    //         $('.amountrow').show('slow');
    //     }
    //     if ($scope.payTyp.id == 2) {
    //         console.log($scope.payTyp);
    //         $('.amountrow').hide('fast');
    //         $('.creditrow').hide('fast');
    //         $('.chequerow').show('slow');
    //     }
    //     if ($scope.payTyp.id == 3) {
    //         console.log($scope.payTyp);
    //         $('.amountrow').hide('fast');
    //         $('.chequerow').hide('fast');
    //         $('.creditrow').show('slow');
    //     }
    // }

    $scope.getRoomsClass = function() {
        return $scope.required_occupants > 1 ? "col-md-6" : "col-md-9";
    }

    $scope.selectRoom = function(room) {
        if (room.st.name == 'Open') {
            $('#room' + room.id).show().css('display', 'flex');

            room.occupants = 1;
            room.room_charges_onbooking = room.RoomCharges;

            $scope.nBooking.rooms.push(room);
            $scope.nBooking.occupants = $scope.nBooking.occupants < $scope.nBooking.rooms.length ? $scope.nBooking.rooms.length : $scope.nBooking.occupants;

            // if ($scope.nBooking.rooms.length > 1) {
            //     let s = 0;
            //     for (let i = 0; i < $scope.nBooking.rooms.length - 1; i++) {
            //         s += $scope.nBooking.rooms[i].hotel_room_category.max_allowed;
            //     }
            //     $scope.nBooking.occupants = s + 1;

            // } else {
            //     // change only when needed
            //     let s = 0;
            //     for (let i = 0; i < $scope.nBooking.rooms.length - 1; i++) {
            //         s += $scope.nBooking.rooms[i].hotel_room_category.max_allowed;
            //     }

            //     if (s > $scope.nBooking.occupants) {
            //         $scope.nBooking.occupants = room.occupants;
            //     }
            // }
        }


        $scope.calculateTotalAmount();

        if ($scope.nBooking.rooms.length > 0) {
            $scope.nBooking.no_rooms = $scope.nBooking.rooms.length;
            $('.selected-rm-detail').show('slow');
            $('.room-container').removeClass('col-lg-12').addClass('col-lg-10');
        } else {
            $('.selected-rm-detail').hide('slow');
            $('.room-container').removeClass('col-lg-10').addClass('col-lg-12');
        }
    }

    $scope.deleteRoom = function(room) {
        if ($scope.lockdown) {
            return;
        }

        // check whether it can be removed or not
        if ($scope.required_occupants - room.occupants < $scope.nBooking.booking_occupants.length + 1) {
            bootbox.dialog({
                closeButton: false,
                title: "Error",
                message: 'Please remove an occupant first',
                buttons: {
                    success: {
                        label: "Ok",
                        callback: function() {
                            return;
                        }
                    }
                }
            });
            return;
        }

        $scope.selectedRoom = angular.copy(room);

        if ($scope.formType == 'edit') {
            console.log($scope.nBooking);
            if ($scope.nBooking.IsCheckedIn > 0) {
                bootbox.alert('Cannot remove room after Check-In');
                return;
            }
        }

        bootbox.confirm({
            title: 'Confirm Cancelation',
            message: "Are you sure you want to remove '" + room.room_title + "' from Booking ?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-link'
                }
            },
            callback: function(result) {
                if (result) {

                    $scope.deselectRoom(room);
                    $scope.required_occupants -= room.occupants;
                    // console.log(room);

                    $scope.$apply();
                }
            }
        });
    }

    $scope.deselectRoom = function(room) {
        $scope.nBooking.rooms = $scope.nBooking.rooms.filter((r) => r.id != room.id);
        $scope.nBooking.no_rooms = $scope.nBooking.rooms.length > 0 ? $scope.nBooking.rooms.length : 1;

        // if ($scope.nBooking.occupants > $scope.nBooking.rooms.length) {
        //     // calculate max allowed without this room
        //     let r_temp = $scope.nBooking.rooms.filter((r) => r.id != room.id);
        //     let s = 0;

        //     for (let i = 0; i < r_temp.length; i++) {
        //         s += r_temp[i].hotel_room_category.max_allowed;
        //     }

        //     // check if occupants are greater than max_allowed, bring them to max_allowed
        //     if (s <= $scope.nBooking.occupants - 1) {
        //         $scope.nBooking.occupants = s > 0 ? s : 1;
        //     } else {
        //         $scope.nBooking.occupants -= $scope.nBooking.occupants - 1 && $scope.nBooking.occupants - 1 < s > 0 ? 1 : 0;
        //     }
        // } else {
        //     $scope.nBooking.occupants -= $scope.nBooking.occupants - 1 > 0 ? room.occupants : 0;
        // }

        $scope.calculateTotalAmount();

        if (!room.st) {
            $scope.rooms = $scope.rooms.filter(function(r) {
                if (r.id == room.id) {
                    r.st.name = 'Open';
                    r.st.text_style = 'text-dark book-room';
                    r.st.card_style = 'bg';
                    return r;
                } else {
                    return r;
                }
            })
        } else {
            $('#room' + room.id).hide();
        }

        if ($scope.nBooking.rooms.length <= 0) {
            $('.selected-rm-detail').hide();
            $('.room-container').removeClass('col-lg-10').addClass('col-lg-12');
        }
    }

    $scope.cancelBooking = function(c) {
        $scope.bookingDetail = angular.copy(c);

        bootbox.prompt({
            title: 'Please enter a reason for cancellation',
            inputType: 'text',
            minlength: 4,
            callback: function(result) {
                if (result) {
                    $scope.ajaxPost('bookings/cancel/' + c.id, {
                        reason: result,
                    }, false).then(function(response) {
                        if (response.id) {
                            $scope.bookings = $scope.bookings.filter(function(booking) {
                                if (booking.id == response.id) {
                                    booking.status = 'Cancelled';
                                    return booking;
                                } else {
                                    return booking;
                                }
                            });

                            $scope.bookingDetail.status = 'Cancelled';

                            // close detail box
                            $scope.hideBookDetailRBox();
                            $scope.afterSaveOrEdit();
                        }
                    }).catch(function(e) {

                    });
                }
            }
        });
    }


    $scope.deleteBooking = function(d) {
        $scope.bookingDetail = angular.copy(d);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + d.customer.FirstName + " " + d.customer.LastName + "'s Booking ?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-link'
                }
            },
            callback: function(result) {
                // if (result) {
                //     $scope.ajaxPost('users/del', $scope.user, false)
                //         .then(function(response) {
                //             $scope.users = $scope.users.filter((user) => user.id != response.id);
                //         })
                //         .catch(function(e) {
                //             toastr.error(e);
                //         })
                // }
            }
        });
    }

    $scope.getStatusClass = function(status) {
        switch (status) {
            case 'Confirmed':
                return 'badge-info';
            case 'Cancelled':
                return 'badge-danger disabled';
            case 'Pending':
                return 'badge-primary';
            case 'CheckedIn':
                return 'badge-success disabled';
            case 'CheckedOut':
                return 'badge-warning disabled';
        }

    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
        $scope.hideBookDetailRBox();
        applyMask();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.showRooms = function() {
        $('#rooms-available').show('slow');
    }



    $scope.hideRooms = function() {
        $('#rooms-available').hide('slow');
    }

    $scope.showTable = function() {
        $('#bookings-table').show('slow');
    }

    $scope.hideTable = function() {
        $('#bookings-table').hide('slow');
        $('.BookDetailRBox').hide();
        $scope.hideFilter();
    }

    $scope.addRooms = function() {
        if ($scope.lockdown)
            return;

        if ($scope.formType == 'edit') {}
        $scope.showSearch()
        $scope.showRooms();
        $('.bookingForm').hide();

        // console.log($scope.nBooking.hotel);
    }

    $scope.resendInvoice = function(id) {
        $scope.ajaxPost('resendBookingInvoice', { id: id }, false)
            .then(function(response) {

            }).catch(function(e) {
                console.log(e);
            });
    }

    $scope.searchAddRooms = function() {
        if ($scope.lockdown)
            return;

        $scope.bookingFrm.$submitted = true;

        if (!$scope.bookingFrm.$valid) {
            return;
        }

        $('.selected-rm-detail').show('slow');
        $('.room-container').removeClass('col-lg-12').addClass('col-lg-10');
        console.log($scope.nBooking.invoice);
        // if ($scope.rooms.length > 0) {
        //     $scope.showRooms();

        //     return;
        // }

        // $scope.nBooking.start_date = $("input[name='start_date']").val();
        // $scope.nBooking.end_date = $("input[name='end_date']").val();

        $scope.nBooking.start_date = moment($scope.start_date).format("YYYY-MM-DD");
        $scope.nBooking.end_date = moment($scope.end_date).format("YYYY-MM-DD");

        $scope.ajaxPost('searchRooms', $scope.nBooking, false)
            .then(function(response) {
                // console.log(response);
                $scope.rooms = response.rooms;
                console.log($scope.rooms);
                let booking_rooms = $scope.nBooking.rooms.map((r) => r.id);
                // console.log(booking_rooms);
                $scope.showRooms();
                $('.selected-rm-detail').hide();
                $('.room-container').removeClass('col-lg-10').addClass('col-lg-12');

                // select rooms which are in the nBooking
                $scope.rooms = $scope.rooms.filter(function(room) {
                    if (booking_rooms.indexOf(room.id) > -1) {
                        room.st.name = "Booked";
                        // room.st.card_style = "bg-success-400";
                        // room.text_style = "text-dark";
                        // room.st.cursor = 'no-cursor';
                        console.log(room.id);
                        return room;
                    } else {
                        return room;
                    }
                })
            }).catch(function(e) {
                console.log(e)
            });
    }

    $scope.incrementOccupants = function() {
        $scope.nBooking.occupants++;
    }

    $scope.decrementOccupants = function() {


        if ($scope.nBooking.occupants > 1) {
            if ($scope.nBooking.rooms.length < $scope.nBooking.occupants)
                $scope.nBooking.occupants--;
        }
    }


    $scope.incrementNights = function() {
        $scope.nights++;
        let e = moment($scope.end_date, "MM/DD/YYYY"); // end date in moment instance
        e.add(1, 'days');
        $scope.end_date = e.format("MM/DD/YYYY");
        $scope.changeEndDate();
        $scope.calculateTotalAmount();
    }

    $scope.decrementNights = function() {
        if ($scope.nights > 1) {
            $scope.nights--;
            let e = moment($scope.end_date, "MM/DD/YYYY"); // end date in moment instance
            e.subtract(1, 'days');
            $scope.end_date = e.format("MM/DD/YYYY");
            $scope.changeEndDate();
            $scope.calculateTotalAmount();
        }
    }

    $scope.incrementRooms = function() {
        $scope.nBooking.no_rooms++;
    }

    $scope.decrementRooms = function() {
        if ($scope.nBooking.rooms && $scope.nBooking.rooms.length > $scope.nBooking.no_rooms - 1) {
            return;
        }

        if ($scope.nBooking.no_rooms > 1) {
            $scope.nBooking.no_rooms--;
        }
    }

    $scope.removeOccupant = function(o) {
        if ($scope.lockdown) {
            return;
        }

        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to remove '" + o.FirstName + ' ' + o.LastName + "' from Booking ?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-link'
                }
            },
            callback: function(result) {
                if (result) {
                    $scope.nBooking.booking_occupants = $scope.nBooking.booking_occupants.filter((c) => c.id != o.id);
                    $scope.$apply();
                }
            }
        });
    }

    $scope.hideCustomerCard = function() {
        if ($scope.lockdown) {
            return;
        }

        $('.customercard').hide('slow');
        $('.customerinfofieldset').show('slow');
        // $scope.nBooking.customer = {};
        // $scope.nBooking.customer.is_cnic = $scope.nBooking.customer.is_cnic
        iti.setCountry($scope.nBooking.customer.iso.toString());
        iti.setNumber(($scope.nBooking.customer.Phone).toString());
        // $scope.nBooking.customer.Phone = iti.getNumber();

        $scope.nBooking.customer.is_cnic = 1;

    }

    $scope.filterData = function() {
        if ($scope.searchBookingDate.trim().length > 1) {
            var sBookingDate = moment($scope.searchBookingDate).format("YYYY-DD-MM");
        }

        if ($scope.searchCheckIn.trim().length > 1) {
            var sCheckIn = moment($scope.searchCheckIn).format("YYYY-DD-MM");
        }

        if ($scope.searchCheckOut.trim().length > 1) {
            var sCheckOut = moment($scope.searchCheckOut).format("YYYY-DD-MM");
        }

        // get all the parameters
        $scope.ajaxGet('getBookings', {
            booking_no: $scope.searchCode,
            customer_name: $scope.searchName,
            hotel_name: $scope.searchHotel,
            phone_no: $scope.searchPhone,
            status: $scope.searchStatus,
            booking_date: sBookingDate,
            checkin_date: sCheckIn,
            checkout_date: sCheckOut,
            occupants: $scope.searchOccupants
        }, true).then(function(response) {
            console.log(response);
            if (response.success) {
                $scope.bookings = response.bookings;
            }
        }).catch(function(e) {
            console.log(e);
        });
    }



    $scope.findOccupant = function() {
        $scope.ajaxPost('findOccupant', {
            cnic: $scope.bookOccupant.CNIC
        }, false).then(function(response) {
            if (response.success) {
                $scope.bookOccupant.FirstName = response.occupant.FirstName;
                $scope.bookOccupant.LastName = response.occupant.LastName;
            }
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.changeHotel = function() {
        // find the select hotel
        $scope.hotel = $scope.hotels.filter((h) => h.id == $scope.nBooking.hotel);
        $scope.hotel = $scope.hotel[0];
        $scope.booking.hotel_id = $scope.hotel.id;

        if ($scope.hotel.has_tax == 0) {
            $scope.nBooking.tax_rate_id = 0;
            $scope.tax_rate = {};
            $scope.TaxValue = 0;
        } else {
            $scope.nBooking.tax_rate_id = $scope.hotel.tax_rate_id;
            $scope.tax_rate = $scope.taxrates.filter((t) => t.id == $scope.hotel.tax_rate_id);
            $scope.tax_rate = $scope.tax_rate[0];
            $scope.nBooking.tax_rate = $scope.tax_rate;
        }
    }

    // called in newBooking
    $scope.enableControls = function() {
        $scope.paid_disabled = false;
        $scope.status_disabled = false;

        // check whether the user can give the discount or not
        $scope.discount_disabled = !$scope.user.can_give_discount && !$scope.user.is_supervisor;
    }

    // called in edit
    $scope.disableControls = function() {
        // 1. Status
        $scope.status_disabled = $scope.nBooking.status == 'CheckedIn' || $scope.nBooking.status == 'CheckedOut' || ($scope.nBooking.discount_request && $scope.nBooking.discount_request.status == 'Pending');

        // 2. Discount
        $scope.discount_disabled = !$scope.user.can_give_discount || $scope.nBooking.invoice.discount_amount > 0 || $scope.nBooking.invoice.paid == 1 || !$scope.user.is_supervisor;

        // 3. Payment Status
        setTimeout(() => {
            $scope.paid_disabled = $scope.nBooking.invoice.paid == 1 ? true : false;
            $scope.$apply();
        }, 600);


        // 4. Checkout Button
        $scope.can_checkout = $scope.nBooking.status == 'CheckedIn';

        if ($scope.nBooking.status == 'CheckedIn') {
            $scope.lockdown = true;
        }
    }

    $scope.checkout = function() {
        // release rooms
        // check the user has paid or not

        if ($scope.nBooking.invoice.paid == 0) {
            bootbox.dialog({
                closeButton: false,
                title: "Error",
                message: 'Checkout cannot be done without payment',
                buttons: {
                    success: {
                        label: "Ok",
                        callback: function() {
                            return;
                        }
                    }
                }
            });
            return;
        }

        $scope.ajaxPost('bookings/checkout', {
            booking: $scope.nBooking
        }, false).then(function(response) {
            if (response.success) {
                response.booking.BookingDate = moment(response.booking.BookingDate).format('MM/DD/YYYY');
                $scope.bookings = $scope.bookings.map((booking) => booking.id == response.booking.id ? response.booking : booking)
                $('#ANR-filter').hide()
                $scope.afterSaveOrEdit();
            }
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.changeStatus = function(booking, status) {
        bootbox.dialog({
            closeButton: false,
            title: "Confirmation",
            message: "Are you sure you want to change the status of (" + booking.booking_no + ") from '" + booking.status + "' to '" + status + "'",
            buttons: {
                success: {
                    label: "Yes",
                    callback: function() {
                        switch (status) {
                            case 'Cancelled':
                                $scope.cancelBooking(booking);
                                break;
                            case 'CheckedOut':
                                // $scope.editBooking(booking.id);

                                // redirect to receipt

                                break;
                            case 'CheckedIn':
                                // $scope.toStatus = "CheckedIn";
                                if (booking.no_occupants != booking.booking_occupants.length) {
                                    $scope.editBooking(booking.id);
                                    $('#statusChange').modal('hide');
                                } else {
                                    $scope.ajaxPost('bookings/changeStatus', {
                                        id: booking.id,
                                        status: status
                                    }, false).then(function(response) {
                                        if (response.success) {
                                            booking.status = status;
                                            $scope.bookings = $scope.bookings.map((b) => b.id == booking.id ? booking : b);
                                            $('#statusChange').modal('hide');
                                        }
                                    }).catch(function(e) {
                                        console.log(e);
                                    });
                                }

                                break;
                                // if ($scope.nBooking.invoice.paid == 0) {
                                //     // you need to pay the price and add the occupants
                                //     if (nBooking.invoice.is_corporate == 0) {
                                //         bootbox.dialog({
                                //             closeButton: false,
                                //             title: "Error",
                                //             message: 'CheckIn cannot be done without payment. Please collect Rs.' + $scope.nBooking.invoice.net_total + ' from the customer before Check-In.',
                                //             buttons: {
                                //                 success: {
                                //                     label: "Ok",
                                //                     callback: function() {
                                //                         $scope.ajaxPost('bookings/changeStatus', {
                                //                             id: booking.id,
                                //                             status: status
                                //                         }, false).then(function(response) {
                                //                             if (response.success) {
                                //                                 booking.status = status;
                                //                                 $scope.bookings = $scope.bookings.map((b) => b.id == booking.id ? booking : b);
                                //                             }
                                //                         }).catch(function(e) {
                                //                             console.log(e);
                                //                         });
                                //                     }
                                //                 }
                                //             }
                                //         });
                                //     }
                                // }
                                // break;
                            default:
                                $scope.ajaxPost('bookings/changeStatus', {
                                    id: booking.id,
                                    status: status
                                }, false).then(function(response) {
                                    if (response.success) {
                                        booking.status = status;
                                        $scope.bookings = $scope.bookings.map((b) => b.id == booking.id ? booking : b);
                                    }
                                }).catch(function(e) {
                                    console.log(e);
                                })
                                break;
                        }
                    }
                },
                cancel: {
                    label: "No",
                    callback: function() {
                        return;
                    }
                }
            }
        });
        return;
    }

    $scope.showInvoiceModal = function(b) {

        $scope.ajaxGet('bookings/find/' + b, {}, true)
            .then(function(response) {
                $scope.Invoice = response.booking;
                
                $scope.renderInvoice();

            }).catch(function(e) {
                console.log(e);
            });
    }

    $scope.renderInvoice = function() {
        $scope.inBooking = false;
        $scope.Invoice.start_date = moment($scope.Invoice.start_date).format('MM/DD/YYYY');
        $scope.Invoice.end_date = moment($scope.Invoice.end_date).format('MM/DD/YYYY');

        $scope.nights = $scope.Invoice.invoice.nights;

        $scope.Invoice.rooms = $scope.Invoice.rooms.map(function(r) {
            r.sub_total = parseFloat(r.pivot.room_charges_onbooking) + parseFloat(r.pivot.additional_guest_charges);
            r.room_charges_onbooking = r.pivot.room_charges_onbooking;

            return r;
        });

        $scope.tax_rate = $scope.Invoice.tax_rate;

        $('#invoiceBox').modal('show');
    }

    $scope.changeOver18 = function() {
        if ($scope.bookOccupant.Over18 == '1' && !$scope.bookOccupant.d_typ) {
            $scope.bookOccupant.d_typ = "1";
        }

        if ($scope.bookOccupant.Over18 == '1') {
            $scope.bookOccupant.d_typ = 1;

            $scope.changeDocTyp(1);
        } else {
            $('.CNIC_required').hide();
            $('.Passport_required').hide();
        }
        //     if ($scope.bookOccupant.d_type == "2") {
        //         $('.Passport_required').show();
        //         $('.CNIC_required').hide();
        //     } else {
        //         $('.CNIC_required').show();
        //         $('.Passport_required').hide();
        //     }
        // } else {
        //     $('.CNIC_required').hide();
        //     $('.Passport_required').hide();
        // }
    }

    $scope.changeDocTyp = function(id) {
        if (id == 1) {
            $(".CNIC_required").show();
            $scope.bookOccupant.Passport = "";
            $(".Passport_required").hide();
        }
        if (id == 2) {
            $(".Passport_required").show();
            $scope.bookOccupant.CNIC = "";
            $(".CNIC_required").hide();
        }
    }

    $scope.changeCity = function() {
        $scope.filteredHotels = $scope.hotels.filter((h) => h.city_id == $scope.nBooking.city_id);

        if ($scope.nBooking.hotel) {
            $scope.nBooking.hotel = {};
        }
    }

    $scope.loadFrontdesk = function() {
        $scope.toStatus = '';
        $scope.inPrint = false;
        $('.bookingForm').hide();
        // search and display rooms
        $scope.getData();

        // show-hide divs
        $('#ANR-filter').show();
        $('#rooms-available').show();
        $scope.formType = 'create';
        $('.customercard').hide();

        $scope.setMinDates();
    }

    $scope.getData = function() {
        $scope.ajaxPost('bookings/getData', {}, true).then(function(response) {
            $scope.paymenttypes = response.paymenttypes;
            $scope.cities = response.cities;
            $scope.hotels = response.hotels;
            $scope.taxrates = response.taxrates;
            $scope.clients = response.clients;
            $scope.channels = response.channels;
            $scope.nationalities = response.nationalities;
            $scope.user = response.user;
            $scope.user_discount_limit = $scope.user.max_allowed_discount;

            if ($scope.user.is_frontdesk) {
                $scope.newBooking();
                $scope.ourRooms();
            } else {

            }
        }).catch(function(e) {
            console.log(e)
        })
    }

    $scope.ourRooms = function() {
        $scope.newBooking();

        $scope.nBooking.hotel = $scope.hotels[0].id;
        $scope.nBooking.city_id = $scope.cities[0].id;
        $scope.getRooms();
    }

    $scope.setMinDates = function() {
        let m = moment().format('MM/DD/YYYY');
        $('#startdate').pickadate('picker').set('min', m);

        $scope.changeStartDate();
    }

    $scope.showCustomer = function(id) {
        $scope.formType = 'view';
        $scope.findBooking(id, function() {
            $scope.nBooking.customer = $scope.fBooking.customer;
            $scope.nBooking.customer.LatestBooking = new Date($scope.nBooking.customer.LatestBooking);
            $scope.nBooking.customer.created_at = new Date($scope.nBooking.customer.created_at);

            $("#customerDetail").modal();
            $(".customercard").show();

            // $scope.nBooking.rooms = [];
        });
    }

    $scope.changeRoomStatus = function(id) {
        $scope.findBooking(id, function() {
            $("#statusChange").modal();
        });
    }

    $scope.checkOutExtend = function(id) {
        $scope.findRoomBooking(id, function() {
            $scope.extend = 1;
            $scope.extended_date = null;
            $scope.fBooking.invoice.checkout_date = new Date($scope.fBooking.invoice.checkout_date);

            var d = new Date($scope.fBooking.invoice.checkout_date);
            d.setDate(d.getDate() + 1);
            $('#extend').pickadate('picker').set('min', (d));
            $("#checkOutExtend").modal();
        })

    }

    $scope.showInvoiceDetails = function(id) {
        $scope.findBooking(id, function() {
            $scope.Invoice = angular.copy($scope.fBooking);
            $scope.renderInvoice();
        });
    }

    $scope.bookingReceipt = function(id) {
        $scope.findRoomBooking(id, function() {
            $scope.old_status = $scope.fBooking.status;
            $scope.viewPOS($scope.fBooking);
        });
        // $scope.findRoomBooking(id, function() {
        //     $scope.Invoice = angular.copy($scope.nBooking);
        //     $scope.nBooking.rooms = [];
        //     $scope.nBooking = {
        //         occupants: 1,
        //         no_rooms: 1
        //     };

        //     // $("#posDetail .modal-content").load('/bookings/receipt/' + $scope.Invoice.id);
        //     $("#posDetail").modal('show');
        //     $scope.current_timestamp = moment().format('MM/DD/YYYY hh:mm:ss A');
        //     // window.open('/bookings/receipt/' + $scope.Invoice.id);
        //     // $scope.ajaxGet('bookings/receipt'.$scope.Invoice.id, {
        //     //     // id: $scope.Invoice.id
        //     // }, true).then(function(response) {
        //     //     if (response.success) {

        //     //     }
        //     // }).catch(function(e) {
        //     //     console.log(e);
        //     // });
        // })
    }

    $scope.findRoomBooking = function(id, callback) {
        $scope.prepareDateForServer();

        $scope.ajaxPost('bookings/find_room_booking', {
            room_id: id,
            start_date: $scope.nBooking.start_date,
            end_date: $scope.nBooking.end_date
        }, true).then(function(response) {
            if (response.success) {
                $scope.fBooking = response.booking;
                $scope.this_booking_rooms = $scope.fBooking.rooms;
                // $scope.nBooking.rooms = [];
                // $scope.nBooking.occupants = 1;
                // $scope.nBooking.no_rooms = 1;
                callback();
            }
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.prepareDateForServer = function() {
        $scope.nBooking.start_date = moment($scope.start_date).format("YYYY-MM-DD");
        $scope.nBooking.end_date = moment($scope.end_date).format("YYYY-MM-DD");
    }

    $scope.resendRoomEmail = function(id) {
        $scope.prepareDateForServer();

        $scope.ajaxPost('bookings/resend_room_email', {
            room_id: id,
            start_date: $scope.nBooking.start_date,
            end_date: $scope.nBooking.end_date
        }, false).then(function(response) {}).catch(function(e) {
            console.log(e);
        })
    }

    $scope.requestForService = function(id) {
        $scope.prepareDateForServer();

        $scope.ajaxPost('bookings/request_or_complain', {
            room_id: id,
            start_date: $scope.nBooking.start_date,
            end_date: $scope.nBooking.end_date
        }, true).then(function(response) {
            // show modal for request
            // $rootScope.housekeepingId = response.redirect_url;
            $rootScope.loadHousekeeping(response.redirect_url, id);
            // $scope.redirect_url = response.redirect_url;
            // window.open('/customerservices/' + $scope.redirect_url);
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.incrementDays = function() {
        if ($scope.extend < 5) {
            $scope.extend++;
        }
    }

    $scope.decrementDays = function() {
        if ($scope.extend > 1) {
            $scope.extend--;
        }
    }

    $scope.extendBooking = function() {
        $scope.extend_booking_form.submitted = true;

        if (!$scope.extend_booking_form.$valid) {
            return;
        }
        console.log($scope.extended_date);
        $scope.ajaxPost('bookings/extend', {
            id: $scope.fBooking.id,
            rooms: $scope.fBooking.rooms.map((r) => r.id),
            // extend: $scope.extend,
            extended_date: $scope.extended_date,
        }, false).then(function(response) {
            if (response.success) {
                $('#checkOutExtend').modal('hide');

                if ($scope.user.is_frontdesk) { $scope.loadFrontdesk(); }
            }
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.hideCustomerDetails = function() {
        $(".customercard").hide();
        $scope.formType = 'create';
        $scope.nBooking.customer = {};
        // $scope.nBooking = {
        //     occupants: 1,
        //     no_rooms: 1
        // }
    }

    $scope.hideStatusChangeModal = function() {
        $('#statusChange').modal('hide');
        $scope.formType = 'create';

        $scope.ourRooms();
    }

    $scope.addMoreOccupants = function() {
        if (!($scope.nBooking.booking_occupants.length < $scope.required_occupants - 1)) {
            bootbox.alert('You can only add ' + ($scope.required_occupants - 1) + ' occupants');
            return;
        }

        $scope.occupant_form.submitted = true;

        if (!$scope.occupant_form.$valid) {
            return;
        }

        // enable bulk edit if not yet
        $scope.bulk_edit_occupants = true;

        // add to occupants
        let new_occupant = {
            FirstName: $scope.bookOccupant.FirstName,
            LastName: $scope.bookOccupant.LastName,
            Over18: $scope.bookOccupant.Over18,
            id: $scope.occupant_key++
        }

        if ($scope.bookOccupant.Over18 == 1) {
            if ($scope.bookOccupant.d_typ == "1") {
                new_occupant.CNIC = $scope.bookOccupant.CNIC;
                $('.CNIC_required').hide();
            }

            if ($scope.bookOccupant.d_typ == "2") {
                new_occupant.Passport = $scope.bookOccupant.Passport;
                $('.Passport_required').hide();
            }
        }

        // add occupant in booking
        if ($scope.occu_form_type == 'edit') {
            $scope.nBooking.booking_occupants = $scope.nBooking.booking_occupants.filter((o) => o.id != $scope.bookOccupant.id);
        }
        $scope.nBooking.booking_occupants.push(new_occupant);

        $scope.occu_form_type = 'create';

        // set pristine
        $scope.bookOccupant = {};
        $scope.occupant_form.$setPristine();
        $scope.occupant_form.$setUntouched();
    }

    // umer - Booking Receipt New Functions
    $scope.hideBookingReceipt = function() {
        $('#posDetail').modal('hide');

        // more things should be done
        if (!$scope.inBooking && $scope.user.is_frontdesk) {
            $scope.loadFrontdesk();
        }

    }

    $scope.printBookingReceipt = function() {
        $("[data-popup='popover']").popover('hide');
        window.print();
        // $scope.inPrint = true;
        // $('#receiptButtons').hide();

        // var domClone = document.getElementById("printThis").cloneNode(true);

        // var $printSection = document.getElementById("printSection");

        // if (!$printSection) {
        //     var $printSection = document.createElement("div");
        //     $printSection.id = "printSection";
        //     document.body.appendChild($printSection);
        // }

        // $printSection.innerHTML = "";
        // $printSection.appendChild(domClone);
    }

    $scope.checkoutFromReceipt = function() {
        // show prompt


        if (parseInt($scope.Invoice.invoice.net_total) > parseInt($scope.Invoice.invoice.payment_amount)) {

            var remaining_amount = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'PKR', minimumFractionDigits: 0 }).format($scope.Invoice.invoice.net_total - $scope.Invoice.invoice.payment_amount);
            toastr.error($scope.Invoice.invoice.customer_first_name + ' ' + $scope.Invoice.invoice.customer_last_name + ' remaining amount is ' + remaining_amount + '. Kindly collect remaining payment before proceed to checkout');
            return false;
        }

        $scope.bed_dead = 0;
        $scope.checkout_in_process = true;
        $scope.checkoutCallback();
        // $('#modalPayment').modal('show');
        // if ($scope.Invoice.invoice.is_corporate != 1 && $scope.Invoice.invoice.payment_amount < $scope.Invoice.invoice.net_total) {
        //     bootbox.confirm({
        //         title: 'Information',
        //         message: "Please collect Rs." + parseInt($scope.Invoice.invoice.net_total - $scope.Invoice.invoice.payment_amount) + " from " + $scope.Invoice.customer.FirstName + ' ' + $scope.Invoice.customer.LastName + " and Checkout",
        //         buttons: {
        //             confirm: {
        //                 label: 'Cash Collected',
        //                 className: 'btn-primary'
        //             },
        //             cancel: {
        //                 label: 'Cancel',
        //                 className: 'btn-link'
        //             }
        //         },
        //         callback: function(result) {
        //             if (result) {
        //                 $scope.checkoutCallback();
        //             }
        //         }
        //     });
        // } else {
        //     $scope.checkoutCallback();
        // }
    }

    $scope.checkoutCallback = function() {

        if (!$scope.paymentIsValid) {
            return;
        }

        let payment_info = {
            paid: 0,
            bed_dead: 0
        };

        // ********** No need of this, as payment already and must be clear before this ***********
        // if ($scope.Invoice.invoice.is_corporate == 0 && $scope.Invoice.invoice.net_total > $scope.Invoice.invoice.payment_amount) {
        //     payment_info.amount = $scope.partial_payment;
        //     payment_info.payment_mode = $scope.partial_payment_typ;
        //     payment_info.bed_dead = $scope.bed_dead;
        //     payment_info.payment_details = $scope.partial_payment_cheque;
        //     payment_info.paid = 1;
        // }

        $scope.ajaxPost('bookings/checkout', {
            booking: {
                id: $scope.Invoice.id,
                payment_info: payment_info
            }
        }, false).then(function(response) {
            // notify user and refresh the page
            if (response.success) {
                $scope.checkout_in_process = false;
                $scope.hideBookingReceipt();
                if ($scope.user.is_frontdesk) {
                    $scope.loadFrontdesk();
                } else {
                    $('#modalPayment').modal('hide');
                    $scope.afterSaveOrEdit();
                    $scope.init();
                }

                $('#modalPayment').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.closeInvoice = function() {
        $('#invoiceBox').modal('hide');

        // if ($scope.user.is_frontdesk) {
        //     $scope.loadFrontdesk();
        // }
    }

    $scope.viewPOS = function(booking) {
        $scope.current_timestamp = $scope.getCurrentTimestamp();
        $scope.Invoice = angular.copy(booking);

        if ($scope.Invoice.invoice.net_total > $scope.Invoice.invoice.payment_amount && $scope.Invoice.invoice.is_corporate == 0) {
            $scope.partial_payment_typ = angular.copy($scope.paymenttypes[0]);
            // $scope.partial_payment_typ = {
            //     id: 1,
            //     PaymentMode: "Cash"
            // }
            $scope.partial_payment = parseFloat($scope.Invoice.invoice.net_total - $scope.Invoice.invoice.payment_amount);
        }

        $("#posDetail").modal('show');
    }

    $scope.getCurrentTimestamp = function() {
        return moment().format('MM/DD/YYYY hh:mm:ss A');
    }

    $scope.adminExtend = function() {
        $scope.fBooking = angular.copy($scope.nBooking);
        $scope.extend = 1;
        $scope.fBooking.invoice.checkout_date = new Date($scope.fBooking.invoice.checkout_date);

        $("#checkOutExtend").modal();
    }

    $scope.adminCustomerDetails = function(bid) {
        $scope.ajaxGet('bookings/find/' + bid, {}, true).then(function(response) {
            if (response.success) {
                $scope.nBooking.customer = response.booking.customer;
                $scope.nBooking.customer.LatestBooking = new Date($scope.nBooking.customer.LatestBooking);
                $scope.nBooking.customer.created_at = new Date($scope.nBooking.customer.created_at);

                $("#customerDetail").modal();
                $(".customercard").show();
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.showPartialPay = function(b) {
        $scope.paymentCleared = false;
        $scope.findBooking(b, function() {
            $scope.addPartialPay();
            if ($scope.formType == 'view') {
                $scope.max_payment = $scope.fBooking.invoice.net_total - $scope.fBooking.invoice.payment_amount;
                if ($scope.max_payment == 0)
                    $scope.paymentCleared = true;
            }
        })
    }

    $scope.addPartialPay = function() {
        $scope.partial_payment = 0;
        $scope.partial_payment_typ = $scope.paymenttypes[0];
        $scope.partial_payment_cheque = "";
        $('.ppCheque').hide();

        $scope.Invoice = $scope.fBooking;
        $scope.checkout_in_process = false;

        if ($scope.formType == 'view') {
            $scope.max_payment = $scope.fBooking.invoice.net_total - $scope.fBooking.invoice.payment_amount;
        }

        $scope.is_partial = 0;
        $scope.formType = 'view';
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();
        $("#addPartialPay").modal('show');
        document.getElementById('bookingForm').reset();
    }

    $scope.findBooking = function(booking_id, callback) {
        $scope.ajaxGet('bookings/find/' + booking_id, {}, true).then(function(response) {
            if (response.success) {
                $scope.fBooking = response.booking;
                $scope.user.name = response.user.name;
                $scope.old_status = $scope.fBooking.status;

                $scope.show_discount = true;
                for (i = 0; i < $scope.fBooking.rooms.length; i++) {
                    if ($scope.fBooking.rooms[i].pivot.room_charges != $scope.fBooking.rooms[i].pivot.room_charges_onbooking) {
                        $scope.show_discount = false;
                        break;
                    }
                }
                callback();
            }
        })
    }

    $scope.bookingReceiptRedirect = function(booking_id) {
        window.open('bookings/receipt/' + booking_id);
    }

    $scope.initReceipt = function(booking_id) {
        $scope.findBooking(booking_id, function() {
            $scope.Invoice = $scope.fBooking;
            $scope.Invoice.service_total = 0;
            // Calculate Service Total
            for (i = 0; i < $scope.Invoice.services.length; i++) {
                $scope.Invoice.service_total += $scope.Invoice.services[i].amount;
            }
            $scope.current_timestamp = $scope.getCurrentTimestamp();
            $scope.inNewPage = true;
        });
    }

    $scope.changePartialPayment = function(p) {
        if (p == '1') {
            $scope.nBooking.invoice.paid = 1;
            if ($scope.formType == 'create') {
                $scope.max_payment = $scope.nBooking.invoice.net_total;
            }

        } else {
            $scope.nBooking.invoice.paid = 0;
        }
    }

    $scope.changePaymentTyp = function() {
        if ($scope.partial_payment_typ.id == 2) {
            $('.ppCheque').show();
        } else {
            $('.ppCheque').hide();
        }
    }

    $scope.paymentIsValid = function() {
        if (!$scope.partial_payment_typ) {
            toastr.error('Please select a Payment Type');
            return false;
        }

        if ($scope.partial_payment_typ.id == 2) {
            if (!$scope.partial_payment_cheque) {
                toastr.error('Please enter a cheque #');
                return false;
            }
            if ($scope.partial_payment_cheque.toString().trim().length < 8) {
                toastr.error('Please enter a valid cheque #');
                return false;
            }
        }

        if (!$scope.partial_payment) {
            toastr.error('Please enter payment amount');
            return false;
        }

        // remove greater payment check
        // if ($scope.formType == 'create') {
        //     if (parseInt($scope.partial_payment) > parseInt($scope.nBooking.invoice.net_total)) {
        //         toastr.error('Payment cannot be greater than ' + $scope.max_payment);
        //         return false;
        //     }
        // } else {
        //     if (parseInt($scope.partial_payment) > parseInt($scope.fBooking.invoice.net_total - $scope.fBooking.invoice.payment_amount)) {
        //         toastr.error('Payment cannot be greater than ' + $scope.max_payment);
        //         return false;
        //     }
        // }

        return true;
    }

    $scope.savePayment = function() {
        if ($scope.formType != 'view') {
            $scope.myForm.$submitted = true;

            if (!$scope.myForm.$valid) {
                return;
            }
        }

        if (!$scope.paymentIsValid()) {
            return;
        }

        // send ajax request to add the amount to the transaction log
        $scope.ajaxPost('bookings/payment/add', {
            booking_id: $scope.fBooking.id,
            payment_amount: $scope.partial_payment,
            payment_type_id: $scope.partial_payment_typ.id,
            payment_type_name: $scope.partial_payment_typ.PaymentMode,
            payment_details: $scope.partial_payment_cheque
        }, false).then(function(response) {
            if (response.success) {
                if ($scope.user.is_frontdesk) { $scope.loadFrontdesk(); }
                $("#addPartialPay").modal('hide');
                $scope.myForm.$setPristine();
                $scope.myForm.$setUntouched();
                document.getElementById('bookingForm').reset();
                if ($scope.formType == 'view' && !$scope.user.is_frontdesk) {
                    $scope.showBookDetailRBox($scope.fBooking.id);
                }
            }
        });
    }

    $scope.getRoomsForTransfer = function(room) {
        $scope.t_room_title = room.room_title;
        $scope.transfer_data = {
            room_id: room.id,
            booking_id: room.booking_id
        }

        $scope.ajaxPost('bookings/transfer/search', $scope.transfer_data, true).then(function(response) {
            if (response.success) {
                $scope.available_rooms = response.rooms;
                $scope.room_checkout_date = moment(response.checkout_date).format('MM/DD/YYYY');

                if ($scope.available_rooms.length == 0) {
                    toastr.error('No rooms available');
                    $('#transferRoom').modal('hide');
                } else {
                    $scope.transfer_form.$setPristine();
                    $scope.transfer_form.$setUntouched();

                    document.getElementById('transfer_form').reset();
                    $('#transferRoom').modal('show');
                }
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.requestRoomTransfer = function() {
        $scope.transfer_form.$submitted = true;

        if (!$scope.transfer_form.$valid) {
            return;
        }

        $scope.transfer_data.new_room = $scope.tranfer_to;
        $scope.transfer_data.end_date = $scope.room_checkout_date;

        $scope.ajaxPost('bookings/transfer/request', $scope.transfer_data, false).then(function(response) {
            if (response.success) {
                if ($scope.user.is_frontdesk) {
                    $('#transferRoom').modal('hide');
                    $scope.loadFrontdesk();
                }
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.changePartialAmount = function() {
        if ($scope.formType == 'create') {
            $scope.fBooking = $scope.nBooking;
        }

        if (parseFloat($scope.partial_payment) > parseFloat($scope.fBooking.invoice.net_total - $scope.fBooking.invoice.payment_amount)) {
            $scope.partial_payment = parseFloat($scope.fBooking.invoice.net_total - $scope.fBooking.invoice.payment_amount)
        }

        $scope.max_payment = $scope.fBooking.invoice.net_total - $scope.fBooking.invoice.payment_amount - parseFloat($scope.partial_payment);
    }

    $scope.getDiscountClass = function(d) {
        return d > $scope.user_discount_limit ? "border-danger-bottom" : "";
    }

    $scope.changeRoomCharges = function() {
        let charges_diff = 0;

        for (let i = 0; i < $scope.nBooking.rooms.length; i++) {
            charges_diff += ($scope.nBooking.rooms[i].RoomCharges) - ($scope.nBooking.rooms[i].room_charges_onbooking);
        }

        if (charges_diff > 0) {
            $scope.nBooking.invoice.per_night = 1;
            $scope.nBooking.invoice.discount_per_night = charges_diff;
            $scope.discount_amount = charges_diff;
            $('.flat_discount').attr('disabled', true);
            $('#discount_amount').attr('disabled', true);
            $scope.show_discount = false;
        } else {
            $scope.show_discount = true;
            $scope.discount_amount = 0;
            $scope.nBooking.invoice.per_night = 0;
            $scope.nBooking.invoice.discount_per_night = 0;
            $('#discount_amount').attr('disabled', false);
            $('.flat_discount').attr('disabled', false);
        }

        $scope.calculateTotalAmount();
    }


    // $scope.cnicPattern = function(c) {
    //     applyMask();
    //     switch (c) {
    //         // case 1:
    //         //     return '[\d]{5}-[\d]{7}-[\d]{1}';
    //         case 0:
    //             return '[A-Za-z0-9]{11}';
    //     }
    // }

    $scope.getcustomer = function(c) {
        applyMask();
        switch (c) {
            case 1:
                return 'cnic';
            case 0:
                return 'alpha_numeric';
        }
    }

    $scope.loadRoomDashboard = function() {
        $scope.toStatus = '';
        $scope.inPrint = false;
        $('.bookingForm').hide();
        // show-hide divs
        $('#ANR-filter').show();
        $('.customercard').hide();
        // search and display rooms
        $scope.getData();
        $scope.in_room_dashboard = true;
        $scope.total_reserved = 0;
    }

    $scope.checkRoomsAvailability = function() {
        $scope.ajaxPost('checkRoomAvailability', {
            start_date: moment($scope.start_date).format("YYYY-MM-DD"),
            end_date: moment($scope.end_date).format("YYYY-MM-DD"),
            rooms: $scope.nBooking.rooms,
            id: $scope.nBooking.id
        }, false).then(function(response) {
            if (response.success) {
                $scope.calculateTotalAmount();
                $("#stayModal").modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.showStayModal = function() {
        $("#stayModal").modal('show');

        $('#checkin_date').pickadate('picker').set('min', moment().format("MM/DD/YYYY"));
        $scope.changeCheckinDate();
        $scope.changeCheckoutDate();
    }
    $scope.hideStayModal = function() {
        $("#stayModal").modal('hide');
    }

    $scope.changeCheckinDate = function() {
        let m = moment($scope.start_date).format('MM/DD/YYYY');
        $('#checkout_date').pickadate('picker').set('min', m);

        if (moment(m).diff(moment($scope.end_date), 'days') > 0)
            $scope.end_date = m;
    }

    $scope.changeCheckoutDate = function() {
        let m = moment($scope.end_date).format('MM/DD/YYYY');
        $('#checkin_date').pickadate('picker').set('max', m);

        if (moment($scope.start_date).diff(moment(m)) > 0)
            $scope.start_date = m;
    }
})
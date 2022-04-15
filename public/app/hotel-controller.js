app.controller('hotelCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    $scope.companies = {};
    $scope.cities = {};
    $scope.partners = {};
    $scope.hotels = [];
    $scope.hotel = {};
    $scope.hotel_contacts = [];
    // $scope.hotel_contacts = [];
    $scope.contact_types = {};
    // $scope.hotelcategories = [];

    $scope.hotelroomcategories = [];

    $scope.searchHotel = "";
    $scope.searchContact = "";
    $scope.formType = "save";
    $scope.contactFormType = "";


    // contact fields
    $scope.contact = {};
    $scope.hrules_cin = [];
    $scope.hrules_cout = [];
    $scope.hotel_sms_config = {
        confirm_message: '',
        cancel_message: '',
        amendment_message: '',
        checkin_message: '',
        checkout_message: '',
    };

    $scope.masking_class = "";

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([3, 4]).notSortable()
    ];

    $scope.removeCheckInRule = function(i) {
        // $scope.check_in_rules.splice(i, 1);
        $scope.hrules_cin.splice(i, 1);
    }
    $scope.removeCheckOutRule = function(i) {
        // $scope.check_out_rules.splice(i, 1);
        $scope.hrules_cout.splice(i, 1);
    }

    $scope.tConvert = function(time) {
        if (time == undefined)
            return "";
        // Check correct time format and split into components
        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time.pop();
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }
        return time.join(''); // return adjusted time or original string
    }

    $scope.init = function() {
        $scope.getHotels();

        $scope.ajaxPost('hotel/get', {}, true)
            .then(function(response) {
                // $scope.hotel_gl_accounts = response.hotel_gl_accounts;
                $scope.companies = response.companies;
                $scope.cities = response.cities;
                $scope.contact_types = response.contact_types;
                // $scope.hotels = response.hotels;
                $scope.partners = response.partners;
                $scope.room_categories = response.room_categories;
                $scope.tax_rates = response.tax_rates;
                $scope.check_in_rules = response.check_in_rules;
                $scope.check_out_rules = response.check_out_rules;
                $scope.default_rule = response.default_rule;
                // console.log($scope.room_categories);


            })
            .catch(function(e) {
                console.log(e);
            })



    }
    $scope.getHotels = function() {
        $scope.ajaxPost('hotels', {}, true)
            .then(function(response) {
                $scope.hotels = response.hotels;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.getTypeClass = function(type) {
        // console.log(type);
        switch (type) {
            case 'Phone':
                return 'fa fa-phone';
            case 'Email':
                return 'fa fa-envelope';
            case 'Fax':
                return 'fa fa-fax';
        }

    }

    $scope.changeStartDate = function() {
        let m = moment($scope.hotel.AgreStartDate).format('MM/DD/YYYY');
        $('#AgreEndDate').pickadate('picker').set('min', m);

        if (moment(m).diff(moment($scope.hotel.AgreEndDate), 'days') > 0)
            $scope.hotel.AgreEndDate = m;
    }

    $scope.changeEndDate = function() {
        let m = moment($scope.hotel.AgreEndDate).format('MM/DD/YYYY');
        $('#AgreStartDate').pickadate('picker').set('max', m);

        if (moment($scope.hotel.AgreStartDate).diff(moment(m)) > 0)
            $scope.hotel.AgreStartDate = m;
    }



    $scope.incrementAllowedOccupants = function(rc, key) {

        if ($scope.hrc[key] == undefined)
            $scope.hrc[key] = {
                allowed: rc.AllowedOccupants,
                max_allowed: rc.MaxAllowedOccupants,
                additional_guest_charges: rc.AdditionalGuestCharges
            }
        if ($scope.hrc[key].allowed < $scope.hrc[key].max_allowed) {
            $scope.hrc[key].allowed++;
        }
    }

    $scope.decrementAllowedOccupants = function(rc, key) {

        if ($scope.hrc[key] == undefined)
        // $scope.hrc[key] = { allowed: rc.AllowedOccupants }
            $scope.hrc[key] = {
            allowed: rc.AllowedOccupants,
            max_allowed: rc.MaxAllowedOccupants,
            additional_guest_charges: rc.AdditionalGuestCharges
        }

        if ($scope.hrc[key].allowed > 1) {
            $scope.hrc[key].allowed--;
        }

    }


    $scope.incrementMaxAllowedOccupants = function(rc, key) {

        if ($scope.hrc[key] == undefined)
        // $scope.hrc[key] = { max_allowed: rc.MaxAllowedOccupants }
            $scope.hrc[key] = {
            allowed: rc.AllowedOccupants,
            max_allowed: rc.MaxAllowedOccupants,
            additional_guest_charges: rc.AdditionalGuestCharges
        }
        $scope.hrc[key].max_allowed++;
    }

    $scope.decrementMaxAllowedOccupants = function(rc, key) {

        if ($scope.hrc[key] == undefined)
            $scope.hrc[key] = {
                allowed: rc.AllowedOccupants,
                max_allowed: rc.MaxAllowedOccupants,
                additional_guest_charges: rc.AdditionalGuestCharges
            }

        if ($scope.hrc[key].max_allowed > 1 && $scope.hrc[key].max_allowed > $scope.hrc[key].allowed) {
            $scope.hrc[key].max_allowed--;
        }
    }

    $scope.clearPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        $scope.hotel.mapimage = null;
    }
    $scope.clearMailPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        $scope.hotel.mailimage = null;
    }
    $scope.clearPosPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        $scope.hotel.posimage = null;
    }

    // $scope.addContact = function() {
    //     $scope.contactForm.$setPristine();
    //     $scope.contactForm.$setUntouched();

    //     $scope.contact = {};
    //     $scope.contactFormType = 'save';
    //     $('#contact_form').modal('show');
    // }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }


    // $scope.saveContact = function() {
    //     $scope.contactForm.$submitted = true;
    //     if (!$scope.contactForm.$valid) {
    //         return;
    //     }
    //     if ($scope.formType == "save") {
    //         if ($scope.contactFormType == 'save') {

    //             $scope.contact.id = $scope.hotel.contacts.length;
    //             $scope.hotel.contacts.push($scope.contact);
    //             console.log($scope.contact);
    //         } else {
    //             $scope.hotel.contacts = $scope.hotel.contacts.map((c) => c.id == $scope.contact.id ? $scope.contact : c);
    //         }
    //         $scope.contact = {};
    //         $('#contact_form').modal('hide');
    //     } else {

    //         $scope.ajaxPost('hotel/saveContact', {
    //             contact: $scope.contact,
    //             formType: $scope.contactFormType,
    //             hotel_id: $scope.hotel.id
    //         }, false).then(function(response) {
    //             if ($scope.contactFormType == "save") {
    //                 if (response.success) {
    //                     $scope.hotel.contacts.push(response.contact);
    //                     $('#contact_form').modal('hide');
    //                 }
    //             } else {
    //                 $scope.hotel.contacts = $scope.hotel.contacts.map((a) => a.id == $scope.contact.id ? $scope.contact : a);
    //                 $('#contact_form').modal('hide');
    //             }
    //             // $('#addNewHotel').hide('hide');
    //             // $scope.init();
    //         }).catch(function(e) {
    //             console.log(e)
    //         });
    //     }

    //     // console.log($scope.hotel.contacts);


    // }



    $scope.hotelRoomCategory = function(r, hrs) {
        // find r in hrc
        let key = 0;
        if (hrs.del) {
            key = $scope.hrc.findIndex((rc) => r.id == rc.id);
        } else {
            key = $scope.hrc.findIndex((h)=>r.id == h.room_category_id);
        }

        $scope.hrc[key].room_category_id = r.id;

        if (!$scope.hrc[key].hasOwnProperty('allowed')) {
            $scope.hrc[key].allowed = r.AllowedOccupants;
        }
        if (!$scope.hrc[key].hasOwnProperty('max_allowed')) {
            $scope.hrc[key].max_allowed = r.MaxAllowedOccupants;
        }
        if (!$scope.hrc[key].hasOwnProperty('additional_guest_charges')) {
            $scope.hrc[key].additional_guest_charges = r.AdditionalGuestCharges;
        }

        if ($scope.formType == "edit") {
            if ($scope.hrc[key].status == '0' && !hrs.del) {
                $scope.ajaxPost('hotel_room_category/room_count', {
                    id: $scope.hrc[key].id
                }, false).then(response => {
                    if (!response.success) {
                        $scope.hrc[key].status = 1;
                    }
                });
            }
            // if ($scope.hrc[key].room_count > 0 && $scope.hrc[key].status == '0') {
            //     $scope.hrc[key].status = '1'
            //     return toastr.error($scope.hrc[key].CategoryName + ' can not be disabled, has ' + $scope.hrc[key].room_count + ' rooms');
            // }
        }
        

        console.log($scope.hrc);
    }

    $scope.addHotel = function() {
        $scope.hotelForm.$setPristine();
        $scope.hotelForm.$setUntouched();


        $scope.formType = "save";
        window.scrollTop();
        $("#addNewHotel").show('slow');
        $(".hotel-navs-tabs .nav-link").removeClass("active show");
        $(".hotel-navs-tabs #basic-info-btn").addClass("active show");
        $(".hotel-tabs .tab-pane").removeClass("active show");
        $(".hotel-tabs #basic_info").addClass("active show");

        $scope.use_default_messages = 0

        $scope.hotel = {
            has_tax: 0,
            // contacts: [],
            // checkout: {},
            // checkin: {},
            // hotelroomcategories: [],
            // checkin_time: $scope.default_rule.checkin_time,
            // checkout_time: $scope.default_rule.checkout_time,

        };

        // $scope.hotel.checkin = $scope.check_in_rules;
        // $scope.hotel.checkout = $scope.check_out_rules;
        // $scope.hotel.check_in_limit = $scope.tConvert($scope.default_rule.checkin_time);
        // $scope.hotel.check_out_limit = $scope.tConvert($scope.default_rule.checkout_time);

        // angular.forEach($scope.hotel.checkin, function(value, key) {
        //     $scope.check_in_rules[key].start_time = $scope.tConvert(value.start_time);
        //     $scope.check_in_rules[key].end_time = $scope.tConvert(value.end_time);
        // });

        // angular.forEach($scope.hotel.checkout, function(value, key) {
        //     $scope.check_out_rules[key].start_time = $scope.tConvert(value.start_time);
        //     $scope.check_out_rules[key].end_time = $scope.tConvert(value.end_time);
        // });

        $('.pickatime-startTime,.pickatime-endTime,.pickatime-startTimeout,.pickatime-endTimeout').pickatime({});

    }

    $scope.saveHotel = function() {
        $scope.hotelForm.$submitted = true;
        if (!$scope.hotelForm.$valid) {
            window.scrollTop();
            return;
        }
        $scope.hotel.AgreStartDate = moment($scope.hotel.AgreStartDate).format("YYYY-MM-DD");
        $scope.hotel.AgreEndDate = moment($scope.hotel.AgreEndDate).format("YYYY-MM-DD");
        console.log($scope.hotel);
        $scope.tempHotel = angular.copy($scope.hotel);
        let request_data = {
            formType: $scope.formType,
            hotel: $scope.tempHotel
        };



        $scope.ajaxPost('hotel/saveHotel', request_data, false)
            .then(function(response) {
                if (response.success) {
                    // delete unnecessary feilds nad object
                    delete response.hotel.city;
                    delete response.hotel.BlockedRoomCount;
                    delete response.hotel.BookingRevenueSum;
                    delete response.hotel.CancelBookingCount;
                    delete response.hotel.ConfirmBookingCount;
                    delete response.hotel.AvailableRoomCount;
                    delete response.hotel.PendingBookingCount;
                    delete response.hotel.TodayCancelBookingCount;
                    delete response.hotel.TodayOccupiedBookingCount;
                    delete response.hotel.TodayConfirmBookingCount;
                    delete response.hotel.TodayPendingBookingCount;
                    delete response.hotel.BookingCount;
                    delete response.hotel.RoomCount;
                    $scope.hotel = response.hotel;
                    $scope.hotel_id = response.hotel_id
                    $("#addNewHotel").show('slow');
                }
            }).catch(function(e) {
                console.log(response);
            })
    }

    $scope.addHotelRoomCategories = function() {
        console.log("here" + $scope.hotel_id);
        $scope.hrc = [];

        if ($scope.formType == 'edit') {
            $scope.ajaxPost('get/hotel_room_categories', {
                    hotel: $scope.hotel.id,
                }, true)
                .then(function(response) {
                    if (response.success) {
                        console.log($scope.room_categories);
                        for (let i = 0; i < response.hrc.length; i++) {
                            delete response.hrc[i].room_category;
                        }
                        // $scope.hrc = response.hrc;
                        $scope.hrc = $scope.room_categories.map((r) => {
                            let f = response.hrc.findIndex(ind => r.id == ind.room_category_id);

                            if (f > -1) {
                                rc = response.hrc[f];
                                rc.room_count = r.room_count;
                                return rc;
                            } else {
                                r.del = 1;
                                r.status = 0;
                                r.room_count = 0;
                                return r;
                            }
                        });

                        console.log($scope.hrc);
                    }
                }).catch(function(e) {
                    console.log(response);
                })
        }
    }

    $scope.saveHotelRoomCategories = function() {

        $scope.hotelRoomCategoryForm.$submitted = true;
        if (!$scope.hotelRoomCategoryForm.$valid) {
            window.scrollTop();
            return;
        }

        $scope.ajaxPost('save_hotel_room_categories', {
                hotel_id: $scope.hotel_id,
                hrc: $scope.hrc.filter(h => h.status == '1'),
            }, false)
            .then(function(response) {
                if (response.success) {
                    // $scope.hrc = $scope.room_categories.map((r) => {
                    //     let f = $scope.hrc.findIndex(ind => r.id == ind.room_category_id);

                    //     if (f > -1) {
                    //         return $scope.hrc[f];
                    //     } else {
                    //         return {del: 1};
                    //     }
                    // });
                    $("#addNewHotel").show('slow');
                }
            }).catch(function(e) {
                console.log(response);
            })
        return;

    }

    $scope.showHotelContacts = function() {
        if ($scope.formType == 'edit') {
            $scope.ajaxPost('get/hotel_contacts', {
                    hotel: $scope.hotel.id,
                }, true)
                .then(function(response) {
                    if (response.success) {
                        console.log(response);
                        $scope.hotel_contacts = response.hotel_contacts;
                    }
                }).catch(function(e) {
                    console.log(response);
                })
        }
    }

    $scope.addContact = function() {
        $scope.contact = {};
        $scope.contactForm.$setPristine();
        $scope.contactForm.$setUntouched();
        $scope.contactFormType = 'save';
        $('#contact_form').modal('show');
    }

    $scope.pushContact = function() {
        if ($scope.contactFormType == 'save') {
            $scope.contact.id = $scope.hotel_contacts.length;

            $scope.hotel_contacts.push($scope.contact);
        } else {
            $scope.hotel_contacts = $scope.hotel_contacts.map((c) => c.id == $scope.contact.id ? $scope.contact : c);
        }
        $('#contact_form').modal('hide');
    }

    $scope.saveContact = function() {
        $scope.contactForm.$submitted = true;
        if (!$scope.contactForm.$valid) {
            return;
        }
        if ($scope.formType == 'edit') {
            $scope.contactFormType = 'edit';
        }
        $scope.ajaxPost('hotel/saveContact', {
            contact: $scope.hotel_contacts,
            formType: $scope.contactFormType,
            hotel_id: $scope.hotel.id
        }, false).then(function(response) {}).catch(function(e) {
            console.log(e)
        });

    }

    $scope.setDefaultRules = function() {

        if ($scope.formType == 'edit') {
            $scope.ajaxPost('get/hotel_rules', {
                    hotel: $scope.hotel.id,
                }, true)
                .then(function(response) {
                    if (response.success) {

                        if (response.hotel_rules_checkin.length > 0) {
                            // $scope.hrules_cin.check_in_limit = $scope.tConvert(response.hotel_rules_checkin[0].check_in_limit);
                            angular.forEach(response.hotel_rules_checkin, function(value, key) {
                                response.hotel_rules_checkin[key].start_time = $scope.tConvert(value.start_time);
                                response.hotel_rules_checkin[key].end_time = $scope.tConvert(value.end_time);
                                response.hotel_rules_checkin[key].check_in_limit = $scope.tConvert(value.check_in_limit);
                            });
                            $scope.hrules_cin = response.hotel_rules_checkin;
                            $scope.hrules_cin.check_in_limit = response.hotel_rules_checkin[0].check_in_limit;
                        }
                        if (response.hotel_rules_checkout.length > 0) {
                            // $scope.hrules_cin.check_out_limit = $scope.tConvert(response.hotel_rules_checkout[0].check_out_limit);
                            angular.forEach(response.hotel_rules_checkout, function(value, key) {
                                response.hotel_rules_checkout[key].start_time = $scope.tConvert(value.start_time);
                                response.hotel_rules_checkout[key].end_time = $scope.tConvert(value.end_time);
                                response.hotel_rules_checkout[key].check_out_limit = $scope.tConvert(value.check_out_limit);
                            });
                            $scope.hrules_cout = response.hotel_rules_checkout;
                            $scope.hrules_cout.check_out_limit = response.hotel_rules_checkout[0].check_out_limit;
                        }


                    }
                }).catch(function(e) {
                    console.log(response);
                })
        } else {
            bootbox.confirm({
                title: 'Confirm',
                message: "Do want to set default rules of checkin & checkout for '" + $scope.hotel.HotelName + "?",
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
                    if (!result) {
                        return;
                    } else {

                        $scope.hrules_cin.check_in_limit = $scope.tConvert($scope.default_rule.checkin_time);
                        $scope.hrules_cout.check_out_limit = $scope.tConvert($scope.default_rule.checkout_time)
                        $scope.$apply();

                        angular.forEach($scope.check_in_rules, function(value, key) {
                            $scope.check_in_rules[key].start_time = $scope.tConvert(value.start_time);
                            $scope.check_in_rules[key].end_time = $scope.tConvert(value.end_time);
                            $scope.check_in_rules[key].check_in_limit = $scope.tConvert(value.check_in_limit);
                        });
                        angular.forEach($scope.check_out_rules, function(value, key) {
                            $scope.check_out_rules[key].start_time = $scope.tConvert(value.start_time);
                            $scope.check_out_rules[key].end_time = $scope.tConvert(value.end_time);

                        });

                        $scope.hrules_cin = $scope.check_in_rules;
                        $scope.hrules_cout = $scope.check_out_rules;



                        $scope.$apply();
                        $('.pickatime-startTime,.pickatime-endTime,.pickatime-startTimeout,.pickatime-endTimeout').pickatime({});

                        $scope.saveCheckInCheckOutRules();

                    }
                }
            });
        }
    }

    $scope.addMoreChekInrule = function() {
        $scope.hrules_cin.push({
            start_time: '',
            end_time: '',
            charges: 0,
        });

        setTimeout(() => {
            $('.pickatime-startTime,.pickatime-endTime,.pickatime-startTimeout,.pickatime-endTimeout').pickatime({});
        }, 500);
    }

    $scope.addMoreChekOutrule = function() {
        $scope.hrules_cout.push({
            start_time: '',
            end_time: '',
            charges: 0,
        });

        setTimeout(() => {
            $('.pickatime-startTime,.pickatime-endTime,.pickatime-startTimeout,.pickatime-endTimeout').pickatime({});
        }, 500);
    }


    $scope.saveCheckInCheckOutRules = function() {

        $scope.ajaxPost('save_hotel_cin_cout_rule', {
                hotel_rules_checkin: $scope.hrules_cin,
                hotel_rules_checkout: $scope.hrules_cout,
                hotel_id: $scope.hotel.id,
                check_out_limit: $scope.hrules_cout.check_out_limit,
                check_in_limit: $scope.hrules_cin.check_in_limit
            }, false)
            .then(function(response) {
                if (response.success) {

                }
            }).catch(function(e) {
                console.log(response);
            })
    }

    $scope.insertToken = function(token) {
        let module = $('#module').val()
        $('#summernote_' + module).summernote('insertText', token);
        $('#InsertTokenModal').modal('hide');
    }

    $scope.getSmsConfiguration = function() {
        if ($scope.formType == 'edit') {
            // reset summer note text
            // $('#summernote_confirm,#summernote_cancel,#summernote_amendment,#summernote_checkin,#summernote_checkout').summernote('reset');
            $('#summernote_confirm').summernote('reset');
            $('#summernote_cancel ').summernote('reset');
            $('#summernote_amendment').summernote('reset');
            $('#summernote_checkin').summernote('reset');
            $('#summernote_checkout').summernote('reset');
            $scope.ajaxPost('get/hotel_sms_configuration', {
                    hotel: $scope.hotel.id,
                }, true)
                .then(function(response) {
                    if (response.success) {
                        if (response.hotel_sms_config) {
                            $scope.use_default_messages = response.hotel_sms_config.use_default_messages;
                            setTimeout(() => {
                                // initialize summernote
                                $scope.summernoteInitialize();
                                $('#summernote_confirm').summernote('insertText', response.hotel_sms_config.confirm_message);
                                $('#summernote_cancel').summernote('insertText', response.hotel_sms_config.cancel_message);
                                $('#summernote_amendment').summernote('insertText', response.hotel_sms_config.amendment_message);
                                $('#summernote_checkin').summernote('insertText', response.hotel_sms_config.checkin_message);
                                $('#summernote_checkout').summernote('insertText', response.hotel_sms_config.checkout_message);
                            }, 500);

                        } else {
                            return;
                        }

                    }
                }).catch(function(e) {
                    console.log(response);
                })
        } else {
            $scope.useDefaultSmsConfiguration();
        }
    }

    $scope.useDefaultSmsCheck = function(val) {
        if (val == 1) {
            $scope.useDefaultSmsConfiguration();
        } else {
            setTimeout(() => {
                // initialize summernote
                $scope.summernoteInitialize();
                $('#summernote_confirm').summernote('insertText', $scope.default_rule.confirm_message);
                $('#summernote_cancel').summernote('insertText', $scope.default_rule.cancel_message);
                $('#summernote_amendment').summernote('insertText', $scope.default_rule.amendment_message);
                $('#summernote_checkin').summernote('insertText', $scope.default_rule.checkin_message);
                $('#summernote_checkout').summernote('insertText', $scope.default_rule.checkout_message);
            }, 500);
        }
    }

    $scope.summernoteInitialize = function() {
        $('#summernote_confirm,#summernote_cancel,#summernote_amendment,#summernote_checkin,#summernote_checkout').summernote({
            toolbar: [
                ['mybuttons', ['btn']]
            ],
            buttons: {
                btn: TokenButton
            }
        });
    }

    $scope.useDefaultSmsConfiguration = function() {
        bootbox.confirm({
            title: 'Confirm',
            message: "Do want to set default sms configuration for '" + $scope.hotel.HotelName + "?",
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
                if (!result) {
                    return;
                } else {
                    setTimeout(() => {
                        $scope.use_default_messages = 1;
                        $scope.hotel_sms_config.confirm_message = $scope.default_rule.confirm_message;
                        $scope.hotel_sms_config.amendment_message = $scope.default_rule.amendment_message;
                        $scope.hotel_sms_config.cancel_message = $scope.default_rule.cancel_message;
                        $scope.hotel_sms_config.checkin_message = $scope.default_rule.checkin_message;
                        $scope.hotel_sms_config.checkout_message = $scope.default_rule.checkout_message;
                        $scope.$apply();
                        $scope.saveSmsConfiguration();
                    }, 500);


                }
            }
        });
    }

    $scope.saveSmsConfiguration = function() {

        if ($scope.use_default_messages == 0) {
            $scope.hotel_sms_config.confirm_message = $($('#summernote_confirm').summernote('code')).text();
            $scope.hotel_sms_config.cancel_message = $($('#summernote_cancel').summernote('code')).text();
            $scope.hotel_sms_config.amendment_message = $($('#summernote_amendment').summernote('code')).text();
            $scope.hotel_sms_config.checkin_message = $($('#summernote_checkin').summernote('code')).text();
            $scope.hotel_sms_config.checkout_message = $($('#summernote_checkout').summernote('code')).text();
        }
        $scope.ajaxPost('save_hotel_sms_configuration', {
                hotel_sms_config: $scope.hotel_sms_config,
                use_default_messages: $scope.use_default_messages,
                hotel_id: $scope.hotel.id
            }, false)
            .then(function(response) {
                if (response.success) {

                }
            }).catch(function(e) {
                console.log(response);
            })
    }



    $scope.getGlAccounts = function() {
        console.log('in');
        $scope.hotel_gl_accounts = [];
        $scope.ajaxPost('hotel/get_account_gl_hotel_mappings', {
                hotel: $scope.hotel.id,
            }, true)
            .then(function(response) {

                if (response.success) {
                    $scope.hotel_gl_accounts = response.hotel_gl_accounts_map;
                    $scope.hotel.hotel_accounts = [];
                    // angular.forEach(response.hotel_gl_accounts_map, function(value, key) {
                    //     console.log(key + ': ' + value);
                    // });
                    angular.forEach(response.hotel_gl_accounts_map, function(value, key) {
                        $scope.hotel.hotel_accounts[value.id] = value.is_active == '1' ? true : false;
                        // this.push(key + ': ' + value);
                    });
                    // $scope.hotel_gl_accounts.forEach(element, key => {
                    //     $scope.hotel.hotel_accounts[key] = element.is_active == '1' ? true : false;
                    // });
                    console.log($scope.hotel.hotel_accounts);
                    // $scope.$apply();
                }
            }).catch(function(e) {
                console.log(response);
            })

    }



    $scope.selectAll = false;
    $scope.is_selected = false;
    $scope.is_checked = false;

    // $scope.selectCheck = function() {
    //     $scope.hotel_gl_accountsTemp = angular.copy($scope.hotel_gl_accounts);
    //     $scope.hotel_gl_accounts = [];

    //     console.log($scope.hotel_gl_accountsTemp);
    //     if (!$scope.selectAll) {
    //         angular.forEach($scope.hotel_gl_accountsTemp, function(value) {
    //             value.is_active = '1';
    //         })
    //         $scope.selectAll = true;
    //     } else {
    //         angular.forEach($scope.hotel_gl_accountsTemp, function(value) {
    //             value.is_active = '0';
    //         })
    //         $scope.selectAll = false;
    //     }
    //     console.log($scope.hotel_gl_accountsTemp);
    //     $scope.hotel_gl_accounts = $scope.hotel_gl_accountsTemp;
    // }

    $scope.selectAllAccounts = function() {
        $scope.hotel_gl_accountsTemp = angular.copy($scope.hotel_gl_accounts);
        $scope.hotel_gl_accounts = [];

        if (!$scope.selectAll) {
            return Object.values($scope.hotel_gl_accountsTemp).filter(function(obj) {
                if(obj != undefined){
                    obj.is_active = '1';
                    $scope.hotel.hotel_accounts[obj.id] = true;
                    $scope.hotel_gl_accounts.push(obj);
                    // return obj.id;
                    $scope.selectAll = true;
                }
            });
        } else {

            return Object.values($scope.hotel_gl_accountsTemp).filter(function(obj) {
                if(obj != undefined){
                    obj.is_active = '0';
                    $scope.hotel.hotel_accounts[obj.id] = false;
                    $scope.hotel_gl_accounts.push(obj);
                    $scope.selectAll = false;
                }
            });
        }
        // HideLoader();


        console.log(gp);
          
        console.log($scope.hotel);
        // $scope.hotel_gl_accounts = gp;
    }

    $scope.saveHotelGlAccountMapping = function() {
        $scope.ajaxPost('hotel/saveHotelGlAccountMapping', {
                hotel_accounts: $scope.hotel.hotel_accounts,
                hotel_id: $scope.hotel.id
            }, false)
            .then(function(response) {
                if (response.success) {

                }
            }).catch(function(e) {
                console.log(response);
            })
    }


    $scope.editHotel = function(h) {
        $scope.formType = "edit"
        $scope.hotelForm.$setPristine();
        $scope.hotelForm.$setUntouched();

        $scope.hotel = angular.copy(h);
        window.scrollTop();
        $("#addNewHotel").show('slow')

        $(".hotel-navs-tabs .nav-link").removeClass("active show");
        $(".hotel-navs-tabs #basic-info-btn").addClass("active show");
        $(".hotel-tabs .tab-pane").removeClass("active show");
        $(".hotel-tabs #basic_info").addClass("active show");
        console.log($scope.hotel);
        $scope.hotel_id = $scope.hotel.id;
        return;

        // console.log($scope.hotel_gl_accounts);

        $scope.hotel.checkin_time = $scope.default_rule.checkin_time
        $scope.hotel.checkout_time = $scope.default_rule.checkout_time
        checkinFound = false;
        limitFound = false;
        if ($scope.hotel.checkin[0] != undefined) {
            checkinFound = true;
            if ($scope.hotel.checkin[0].check_in_limit)
                limitFound = true;
        }
        $scope.hotel.check_in_limit = $scope.tConvert(limitFound ? $scope.hotel.checkin[0].check_in_limit : $scope.default_rule.checkin_time);
        $scope.hotel.check_out_limit = $scope.tConvert(limitFound ? $scope.hotel.checkout[0].check_out_limit : $scope.default_rule.checkout_time);

        $scope.check_in_rules = checkinFound ? $scope.hotel.checkin : $scope.check_in_rules;
        $scope.check_out_rules = checkinFound ? $scope.hotel.checkout : $scope.check_out_rules;

        angular.forEach($scope.hotel.checkin, function(value, key) {
            $scope.check_in_rules[key].start_time = $scope.tConvert(value.start_time);
            $scope.check_in_rules[key].end_time = $scope.tConvert(value.end_time);
        });

        angular.forEach($scope.hotel.checkout, function(value, key) {
            $scope.check_out_rules[key].start_time = $scope.tConvert(value.start_time);
            $scope.check_out_rules[key].end_time = $scope.tConvert(value.end_time);
        });
        // console.log('in');
        // $scope.hotel_gl_accounts = [];
        // $scope.ajaxPost('hotel/get_account_gl_hotel_mappings', {
        //         hotel: $scope.hotel.id,
        //     }, true)
        //     .then(function(response) {
        //         console.log('here');

        //         console.log(response);
        //         if (response.success) {
        //             $scope.hotel_gl_accounts = response.hotel_gl_accounts_map;
        //             $scope.hotel.hotel_accounts = [];
        //             // angular.forEach(response.hotel_gl_accounts_map, function(value, key) {
        //             //     console.log(key + ': ' + value);
        //             // });
        //             angular.forEach(response.hotel_gl_accounts_map, function(value, key) {
        //                 $scope.hotel.hotel_accounts[value.id] = value.is_active == '1' ? true : false;
        //                 // this.push(key + ': ' + value);
        //             });
        //             // $scope.hotel_gl_accounts.forEach(element, key => {
        //             //     $scope.hotel.hotel_accounts[key] = element.is_active == '1' ? true : false;
        //             // });
        //             console.log($scope.hotel.hotel_accounts);
        //             // $scope.$apply();
        //         }
        //     }).catch(function(e) {
        //         console.log(response);
        //     })



        $('.pickatime-startTime,.pickatime-endTime,.pickatime-startTimeout,.pickatime-endTimeout').pickatime({});
    }
    $scope.getLevel = function(lvl) {
        switch (lvl) {
            case '1':
                return 'level-1';
            case '2':
                return 'pl-2';
            case '3':
                return 'pl-3';
            case '4':
                return 'pl-4';
            case '5':
                return 'pl-5';
        }
    }

    $scope.editContact = function(c) {

        $scope.contactForm.$setPristine();
        $scope.contactForm.$setUntouched();

        $scope.contactFormType = 'edit';
        $scope.contact = angular.copy(c);
        $('#contact_form').modal('show');

    }




    $scope.deleteHotel = function(h) {
        if (h.RoomCount > 0) {
            bootbox.alert('This hotel cannot be deleted because it has ' + h.RoomCount + ' rooms already.');
            return;
        }

        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + h.HotelName + "?",
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
                if (!result)
                    return;
                $scope.ajaxPost('hotel/deleteHotel', { id: h.id }, false).then(function(response) {
                    $scope.hotels = $scope.hotels.filter((h) => h.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }

    $scope.deleteContact = function(c) {
        $scope.contact = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.ContactPerson + "'?",
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
                    if ($scope.formType == 'save') {
                        $scope.hotel_contacts = $scope.hotel_contacts.filter((contact) => contact.id != c.id);
                        $scope.contact = {};
                        $scope.$apply();
                    } else {
                        $scope.ajaxPost('hotel/deleteContact', { id: $scope.contact.id }, false)
                            .then(function(response) {
                                $scope.hotel_contacts = $scope.hotel_contacts.filter((contact) => contact.id != response.id);
                            })
                            .catch(function(e) {
                                toastr.error(e);
                            })
                    }



                }
            }
        });
    }

    $scope.getMaskingClass = function() {
        applyMask();
    }

    $scope.revert = function() {
        $("#addNewHotel").hide('slow')
    }

    $scope.checkRequired = function(a) {
        if (a == 1) {
            return true;
        } else {
            return false;
        }
    }
});
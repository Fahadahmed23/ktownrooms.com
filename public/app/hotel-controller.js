app.controller('hotelCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    $scope.companies = {};
    $scope.cities = {};
    $scope.partners = {};
    $scope.hotels = [];
    $scope.hotel = {};

    // Hotel Categories
    $scope.hotel_categories = {};
  
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
        $scope.check_in_rules.splice(i, 1);
    }
    $scope.removeCheckOutRule = function(i) {
        $scope.check_out_rules.splice(i, 1);
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
        $scope.ajaxPost('hotel/get', {}, true)
            .then(function(response) {
                // $scope.hotel_gl_accounts = response.hotel_gl_accounts;
                $scope.companies = response.companies;
                $scope.cities = response.cities;
                $scope.contact_types = response.contact_types;
                $scope.hotels = response.hotels;
                $scope.partners = response.partners;
                $scope.partners = response.partners;
                $scope.room_categories = response.room_categories;
                $scope.hotel_categories = response.hotel_categories;
                $scope.tax_rates = response.tax_rates;
                $scope.check_in_rules = response.check_in_rules;
                $scope.check_out_rules = response.check_out_rules;
                $scope.default_rule = response.default_rule;
                // console.log($scope.room_categories);

                //console.log('Hotel Categories');
                //console.log($scope.hotel_categories);


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



    $scope.incrementAllowedOccupants = function(rc) {

        if ($scope.hotel.hotelroomcategories[rc.id] == undefined)
            $scope.hotel.hotelroomcategories[rc.id] = {
                allowed: rc.AllowedOccupants,
                max_allowed: rc.MaxAllowedOccupants,
                additional_guest_charges: rc.AdditionalGuestCharges
            }
        if ($scope.hotel.hotelroomcategories[rc.id].allowed < $scope.hotel.hotelroomcategories[rc.id].max_allowed) {
            $scope.hotel.hotelroomcategories[rc.id].allowed++;
        }
    }

    $scope.decrementAllowedOccupants = function(rc) {

        if ($scope.hotel.hotelroomcategories[rc.id] == undefined)
        // $scope.hotel.hotelroomcategories[rc.id] = { allowed: rc.AllowedOccupants }
            $scope.hotel.hotelroomcategories[rc.id] = {
            allowed: rc.AllowedOccupants,
            max_allowed: rc.MaxAllowedOccupants,
            additional_guest_charges: rc.AdditionalGuestCharges
        }

        if ($scope.hotel.hotelroomcategories[rc.id].allowed > 1) {
            $scope.hotel.hotelroomcategories[rc.id].allowed--;
        }

    }


    $scope.incrementMaxAllowedOccupants = function(rc) {

        if ($scope.hotel.hotelroomcategories[rc.id] == undefined)
        // $scope.hotel.hotelroomcategories[rc.id] = { max_allowed: rc.MaxAllowedOccupants }
            $scope.hotel.hotelroomcategories[rc.id] = {
            allowed: rc.AllowedOccupants,
            max_allowed: rc.MaxAllowedOccupants,
            additional_guest_charges: rc.AdditionalGuestCharges
        }
        $scope.hotel.hotelroomcategories[rc.id].max_allowed++;
    }

    $scope.decrementMaxAllowedOccupants = function(rc) {

        if ($scope.hotel.hotelroomcategories[rc.id] == undefined)
            $scope.hotel.hotelroomcategories[rc.id] = {
                allowed: rc.AllowedOccupants,
                max_allowed: rc.MaxAllowedOccupants,
                additional_guest_charges: rc.AdditionalGuestCharges
            }

        if ($scope.hotel.hotelroomcategories[rc.id].max_allowed > 1 && $scope.hotel.hotelroomcategories[rc.id].max_allowed > $scope.hotel.hotelroomcategories[rc.id].allowed) {
            $scope.hotel.hotelroomcategories[rc.id].max_allowed--;
        }
    }

    $scope.clearPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        $scope.hotel.mapimage = null;
    }

    $scope.addContact = function() {
        $scope.contactForm.$setPristine();
        $scope.contactForm.$setUntouched();

        $scope.contact = {};
        $scope.contactFormType = 'save';
        $('#contact_form').modal('show');
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }


    $scope.saveContact = function() {
        $scope.contactForm.$submitted = true;
        if (!$scope.contactForm.$valid) {
            return;
        }
        if ($scope.formType == "save") {
            if ($scope.contactFormType == 'save') {

                $scope.contact.id = $scope.hotel.contacts.length;
                $scope.hotel.contacts.push($scope.contact);
                console.log($scope.contact);
            } else {
                $scope.hotel.contacts = $scope.hotel.contacts.map((c) => c.id == $scope.contact.id ? $scope.contact : c);
            }
            $scope.contact = {};
            $('#contact_form').modal('hide');
        } else {

            $scope.ajaxPost('hotel/saveContact', {
                contact: $scope.contact,
                formType: $scope.contactFormType,
                hotel_id: $scope.hotel.id
            }, false).then(function(response) {
                if ($scope.contactFormType == "save") {
                    if (response.success) {
                        $scope.hotel.contacts.push(response.contact);
                        $('#contact_form').modal('hide');
                    }
                } else {
                    $scope.hotel.contacts = $scope.hotel.contacts.map((a) => a.id == $scope.contact.id ? $scope.contact : a);
                    $('#contact_form').modal('hide');
                }
                // $('#addNewHotel').hide('hide');
                // $scope.init();
            }).catch(function(e) {
                console.log(e)
            });
        }

        // console.log($scope.hotel.contacts);


    }



    $scope.hotelRoomCategory = function(r) {
        console.log(r);
        if (!$scope.hotel.hotelroomcategories[r.id].hasOwnProperty('allowed')) {
            $scope.hotel.hotelroomcategories[r.id].allowed = r.AllowedOccupants;
        }
        if (!$scope.hotel.hotelroomcategories[r.id].hasOwnProperty('max_allowed')) {
            $scope.hotel.hotelroomcategories[r.id].max_allowed = r.MaxAllowedOccupants;
        }
        if (!$scope.hotel.hotelroomcategories[r.id].hasOwnProperty('additional_guest_charges')) {
            $scope.hotel.hotelroomcategories[r.id].additional_guest_charges = r.AdditionalGuestCharges;
        }
    }

    $scope.addHotel = function() {
        $scope.hotelForm.$setPristine();
        $scope.hotelForm.$setUntouched();


        $scope.formType = "save";
        window.scrollTop();
        $("#addNewHotel").show('slow');
        
        $scope.hotel = {
            has_tax: 0,
            has_cobranding: 0,
            contacts: [],
            checkout: {},
            checkin: {},
            hotelroomcategories: [],
            checkin_time: $scope.default_rule.checkin_time,
            checkout_time: $scope.default_rule.checkout_time,

        };

        $scope.hotel.checkin = $scope.check_in_rules;
        $scope.hotel.checkout = $scope.check_out_rules;
        $scope.hotel.check_in_limit = $scope.tConvert($scope.default_rule.checkin_time);
        $scope.hotel.check_out_limit = $scope.tConvert($scope.default_rule.checkout_time);

        angular.forEach($scope.hotel.checkin, function(value, key) {
            $scope.check_in_rules[key].start_time = $scope.tConvert(value.start_time);
            $scope.check_in_rules[key].end_time = $scope.tConvert(value.end_time);
        });

        angular.forEach($scope.hotel.checkout, function(value, key) {
            $scope.check_out_rules[key].start_time = $scope.tConvert(value.start_time);
            $scope.check_out_rules[key].end_time = $scope.tConvert(value.end_time);
        });

        $('.pickatime-startTime,.pickatime-endTime,.pickatime-startTimeout,.pickatime-endTimeout').pickatime({});

    }

    $scope.saveHotel = function() {

        /*
        console.log('Hotel Category');
        console.log($scope.hotel.hotelcateogry_id);
        console.log('Hotel Cobranding');
        console.log($scope.hotel.has_cobranding);
        console.log('Hotel Software Fees');
        console.log($scope.hotel.software_fees);
        console.log('Hotel Percentage Ammount');
        console.log($scope.hotel.percentage_amount);
    
        console.log('Fahad Ahmed ZIndabad and He is a great programmer');
        return;

        **/

        //console.log('hahah you want to save');
        //return;

        $scope.hotelForm.$submitted = true;
        if (!$scope.hotelForm.$valid) {
            window.scrollTop();
            return;
        }
        $scope.hotel.AgreStartDate = moment($scope.hotel.AgreStartDate).format("YYYY-MM-DD");
        $scope.hotel.AgreEndDate = moment($scope.hotel.AgreEndDate).format("YYYY-MM-DD");

        $scope.ajaxPost('hotel/saveHotel', {
                formType: $scope.formType,
                hotel: $scope.hotel,
                hotel_accounts: $scope.hotel.hotel_accounts,
            }, false)
            .then(function(response) {
                console.log(response);
                if (response.success) {
                    // if ($scope.formType == "save") {
                    //     $scope.hotels.push(response.hotel);
                    // } else {
                    //     $scope.hotels = $scope.hotels.map((hotel) => hotel.id == response.hotel.id ? response.hotel : hotel);
                    // }
                    // $scope.hotel = {};
                    $scope.init();
                    $("#addNewHotel").hide('slow')
                }
            }).catch(function(e) {
                console.log(response);
            })
    }

    $scope.selectAll = false;
    $scope.is_selected = false;
    $scope.selectCheck = function() {
        $scope.hotel_gl_accountsTemp = angular.copy($scope.hotel_gl_accounts);
        $scope.hotel_gl_accounts = [];

        console.log($scope.hotel_gl_accountsTemp);
        if (!$scope.is_selected) {
            angular.forEach($scope.hotel_gl_accountsTemp, function(value) {
                value.is_active = '1';
            })
            $scope.is_selected = true;
        } else {
            angular.forEach($scope.hotel_gl_accountsTemp, function(value) {
                value.is_active = '0';
            })
            $scope.is_selected = false;
        }
        console.log($scope.hotel_gl_accountsTemp);
        $scope.hotel_gl_accounts = $scope.hotel_gl_accountsTemp;
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
        $scope.formType == "edit"
        $scope.hotelForm.$setPristine();
        $scope.hotelForm.$setUntouched();

        $scope.hotel = angular.copy(h);

        // Arman Bhai
        //$scope.hotel.has_cobranding = 1;
        //$scope.hotel.softwarefees = 2;
        //$scope.hotel.percentageamount = 2;

        $scope.hotel.has_cobranding = 0;
        $scope.hotel.software_fees = 0;
        $scope.hotel.percentage_amount = 0;

   

        console.log('Hotel Info');
        console.log($scope.hotel);

        //console.log('Hotel Categories');
        //console.log($scope.hotel.hotel_categories);
        //console.log($scope.hotel.hotel_categories[0]);
        
        if ($scope.hotel.hotel_categories[0] != undefined) {
            
            console.log('Hotel Category Id');
            $scope.hotel.hotelcateogry_id = $scope.hotel.hotel_categories[0].id;
            console.log($scope.hotel.hotelcateogry_id);
            
        }
    
        if ($scope.hotel.hotel_cobrandings[0] != undefined) {
            
            console.log('Hotel cobranding status');
            $scope.hotel.has_cobranding = $scope.hotel.hotel_cobrandings[0].status;
            $scope.hotel.has_cobranding = parseInt($scope.hotel.has_cobranding); 
            //$scope.hotel.has_cobranding = 1;
            //console.log('Hotel cobranding status type');
            //console.log(typeof $scope.hotel.has_cobranding);
            console.log($scope.hotel.has_cobranding);

            console.log('Hotel software fee');
            $scope.hotel.software_fees = $scope.hotel.hotel_cobrandings[0].software_fee;
            $scope.hotel.software_fees = parseInt($scope.hotel.software_fees);
            console.log($scope.hotel.software_fees);

            console.log('Hotel percentage amount');
            $scope.hotel.percentage_amount = $scope.hotel.hotel_cobrandings[0].percentage_amount;
            $scope.hotel.percentage_amount = parseInt($scope.hotel.percentage_amount);
            console.log($scope.hotel.percentage_amount);
    
        }

        console.log('Hotel Info 2');
        console.log($scope.hotel);

       
        // $scope.hotel_gl_accounts = $scope.hotel_gl_accounts;
        $scope.formType = "edit";
        window.scrollTop();
        $("#addNewHotel").show('slow')
       
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
        console.log('in');
        $scope.hotel_gl_accounts = [];
        $scope.ajaxPost('hotel/get_account_gl_hotel_mappings', {
                hotel: $scope.hotel.id,
            }, true)
            .then(function(response) {
                console.log('here');
                console.log(response);
                
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
                        $scope.hotel.contacts = $scope.hotel.contacts.filter((contact) => contact.id != s.id);
                        $scope.contact = {};
                        $scope.$apply();
                    } else {
                        $scope.ajaxPost('hotel/deleteContact', { id: $scope.contact.id }, false)
                            .then(function(response) {
                                $scope.hotel.contacts = $scope.hotel.contacts.filter((contact) => contact.id != response.id);
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
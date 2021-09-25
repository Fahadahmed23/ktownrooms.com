app.controller('housekeepingCtrl', function($scope, $rootScope, DTColumnDefBuilder, DTOptionsBuilder, $interval) {
    $scope.code = "";

    // variables
    $scope.booking = {};
    $scope.departments = {};
    $scope.department_services = {};
    $scope.housekeeping = {};
    $scope.cutomers_complains = {};
    $scope.booking_service = {};
    $scope.today = "";
    $scope.user_frontdesk = false;
    $scope.curHr = "";
    $rootScope.new_service_available = false;

    // invoice
    $scope.total_amount = 0;
    $scope.service_request = {
        services: []
    };
    $scope.requested = 0;

    // show / hide sections
    $scope.total_requested = 0;
    $scope.total_included = 0;
    $scope.total_excluded = 0;
    $scope.other_id = 5000;

    // complain subjects
    $scope.complain_subjects = [
        { id: 1, subject: "Staff is misbehaving" },
        { id: 2, subject: "My clothes were not pressed properly" },
        { id: 3, subject: "Other" },
        { id: 4, subject: "I have not received my shirt" },
    ];

    $scope.seleted_department_id = 0;

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([3, 4]).notSortable()
    ];

    $scope.$on('service_modal', function(id) {
        $scope.inModal = true;
        $scope.init($rootScope.bookingId);
    });

    // functions
    $scope.init = function(c) {
        $scope.today = new Date();
        $scope.curHr = $scope.today.getHours()
        if ($scope.curHr < 12) {
            $scope.greetMessage = 'Good Morning';
        } else if ($scope.curHr < 18) {
            $scope.greetMessage = 'Good Afternoon';
        } else {
            $scope.greetMessage = 'Good Evening';
        }

        $scope.code = angular.copy(c);
        $scope.ajaxGet('getCustomer/' + $scope.code, {}, true)
            .then(function(response) {
                $scope.booking = response.booking;
                $scope.departments = response.departments;
                $scope.services = response.services;
                $scope.cutomers_complains = response.cutomers_complains;
                $scope.booking_service = response.booking_service.map(function(b) {
                    b.created_at = new Date(b.created_at);

                    return b;
                });
                console.log($scope.booking_service);

                $scope.booking.BookingDate = moment($scope.booking.BookingDate).format('MM/DD/YYYY');
                for (let i = 0; i < $scope.cutomers_complains.length; i++) {
                    $scope.cutomers_complains[i].ComplainTime = moment($scope.cutomers_complains[i].ComplainTime).format('MM/DD/YYYY')
                }

                if ($scope.inModal) {
                    $scope.service_request.room_id = $rootScope.roomId;
                    $scope.user_frontdesk = true;

                    $scope.getDeptServices($scope.departments[0].id);

                    $('#addNewServiceRequest').modal('show');
                }
            }).catch(function(e) {
                console.log(e);
            })
    }

    $scope.createComplain = function() {
        $scope.housekeepingForm.$setPristine();
        $scope.housekeepingForm.$setUntouched();
        $scope.housekeeping = {};

        $('#addNewComplain').modal('show');
        if ($scope.booking.rooms.length == 1) {
            $scope.housekeeping.room_id = $scope.booking.rooms[0].id
            console.log($scope.housekeeping);
        }

    }

    $scope.hideComplainModal = function() {
        $('#addNewComplain').modal('hide');
    }


    $scope.saveComplain = function() {
        $scope.housekeepingForm.$submitted = true;
        if (!$scope.housekeepingForm.$valid) {
            return;
        }

        $scope.ajaxPost('saveComplain', {
                housekeeping: $scope.housekeeping,
                booking_id: $scope.booking.id,
                customer_id: $scope.booking.customer_id,
                customerName: $scope.booking.customer.FirstName + ' ' + $scope.booking.customer.LastName,
                booking_no: $scope.booking.booking_no,
            }, false)
            .then(function(response) {
                if (response.success) {
                    // $("#mycomplain-tab").addClass('active show');
                    // $("#complain-form-tab").removeClass('active show');
                    // $("#c_table-tab").addClass('active show');
                    // $("#c_form_tab").removeClass('active show');
                    response.complain.ComplainTime = new Date(response.complain.ComplainTime);
                    $scope.cutomers_complains.push(response.complain);
                }
            })
            .catch(function(e) {
                console.log(e);
            });
    }

    $scope.createRequest = function() {
        $("#complainFormBtns").hide('slow');
        $("#serviceFormBtns").show();
        $(".complain_btn").show('slow');
        $(".bck_btn_row").show('slow');
    }

    $scope.createOtherRequest = function() {
        if ($scope.booking.rooms.length == 1) {
            $scope.service_request.room_id = $scope.booking.rooms[0].id
        }

        // $('#otherTabHeading').addClass('active show');
        $scope.showOther();

        $scope.service_request.other = true;
        $('#addNewServiceRequest').modal('show');
    }

    $scope.createServiceRequest = function(id) {
        $scope.hideRequest_Complains();
        $('#addNewServiceRequest').modal('show');

        if ($scope.booking.rooms.length == 1) {
            $scope.service_request.room_id = $scope.booking.rooms[0].id
        }

        $scope.getDeptServices(id);
        $('.services-tab-pane').removeClass('col-md-8').addClass('col-md-12')
    }

    $scope.showOther = function() {
        $("#other_service_tab").addClass('active show');
        $('#otherTabHeading').addClass('active show');

        $scope.department_services = [];
        $scope.seleted_department_id = 0;

        $scope.service_request.other = true;
    }

    $scope.hideServiceModal = function() {
        $('#addNewServiceRequest').modal('hide');
        // clear services
        $scope.service_request.services = [];
    }

    $scope.getDeptServices = function(did) {
        $('#other_service_tab').removeClass('active show');
        $('#otherTabHeading').removeClass('active show');

        $scope.service_request.other = false;

        // $("#other_service_tab").removeClass('active show');
        // $("#other_ser_tab").removeClass('active show');

        $scope.seleted_department_id = did;
        $scope.service_request.department_id = did;

        // $scope.service_request.services = [];

        $scope.ajaxGet('getDeptServices/' + did, {
                booking_id: $scope.booking.id,
                hotel_id: $scope.booking.hotel_id,
                room_id: $scope.service_request.room_id
            }, true)
            .then(function(response) {
                $scope.department_services = response.department_services;
                console.log($scope.department_services);

                for (let i = 0; i < $scope.department_services.length; i++) {
                    if ($scope.department_services[i].ServingTime >= 60) {
                        $scope.department_services[i].ServingTime = (parseInt($scope.department_services[i].ServingTime) / 60).toFixed(2) + ' Hrs';
                    } else {
                        $scope.department_services[i].ServingTime = $scope.department_services[i].ServingTime + ' Mins';
                    }
                    // console.log($scope.servingTime);
                }


                // enable disable services()
                $scope.enableDisableServices();

                // $scope.service_request.requested_services = [];

                // allowed services in that room
                // $scope.calculateInclusiveExclusive();
            }).catch(function(e) {
                console.log(e);
            })
    }

    $scope.enableDisableServices = function() {
        // $scope.service_request.services = [];
        if (!$scope.service_request.services) {
            $scope.service_request.services = [];
        }
        // $scope.total_amount = 0;

        let current_time = moment();
        let current_room = $scope.booking.rooms.filter((r) => r.id == $scope.service_request.room_id);

        $scope.department_services = $scope.department_services.map(function(s) {
            let start_time = moment(s.service_start_time, 'HH:mm:ss');
            let end_time = moment(s.service_end_time, 'HH:mm:ss');

            let service_in_room = current_room[0].services.filter((sv) => s.id == sv.id);

            if (start_time._isValid || end_time._isValid) {
                if (current_time.isBetween(start_time, end_time)) {
                    s.enable = true;
                } else {
                    s.enable = false;
                    s.msg = "You can't avail this service. It is available between " + start_time.format('HH:mm A') + " & " + end_time.format('HH:mm A');
                }
            } else {
                s.enable = true;
            }
            if (service_in_room.length > 0) {
                // s.includes = service_in_room[0].pivot.limit;
                s.includes = current_room[0].pivot.occupants < s.availed ? 0 : current_room[0].pivot.occupants - s.availed;
                s.excludes = 0;
            } else {
                s.includes = 0;
                s.excludes = 0;
            }

            s.amount = 0;

            // s.times = 1;

            s.times = 0;

            return s;

        });

        setTimeout(() => {
            $('[data-popup="popover"]').popover();
        }, 1000);
    }

    $scope.addService = function(service) {
        // $("#servicesDetailRBox").show('slow');

        $scope.service_request.services = $scope.service_request.services.filter((s) => s.id != service.id);

        $scope.service_request.services.push(service);
        $scope.total_requested++;
        $scope.calculateServiceCharges();
    }

    $scope.removeService = function(service) {
        $scope.service_request.services = $scope.service_request.services.filter((s) => s.id != service.id);

        $scope.calculateServiceCharges();
    }

    $scope.calculateServiceCharges = function() {
        $scope.total_amount = 0;
        $scope.total_included = 0;
        $scope.total_excluded = 0;

        // umer
        $scope.service_request.services = $scope.service_request.services.map(function(s) {
            if (s.is_other) {
                $scope.total_amount += parseFloat(s.amount);
                $scope.total_excluded += parseInt(s.excludes);
                return s;
            }

            if (s.times > s.includes) {
                s.excludes = parseInt(s.times - s.includes);
                s.amount = parseFloat(s.excludes * s.Charges);

                $scope.total_amount += s.amount;
                $scope.total_excluded += s.excludes;
                $scope.total_included += s.includes;
            } else {
                $scope.total_included += s.times;
                s.amount = 0;
            }

            $scope.total_requested += s.times;

            return s;
        });
    }

    $scope.incrementTimes = function(s) {
        s.times++;
        $scope.calculateServiceCharges();
        $scope.addService(s);
        $('.services-tab-pane').removeClass('col-md-12').addClass('col-md-8')
    }

    $scope.decrementTimes = function(s) {
        if (s.times >= 1) {
            s.times--;
            if (s.times == 0) {
                $scope.removeService(s);
            } else {
                $scope.calculateServiceCharges();
                $scope.addService(s);
            }
        }
    }

    $scope.getDeptId = function(did) {
        return $scope.seleted_department_id == did ? 'active' : '';
    }

    $scope.saveRequest = function() {
        $scope.service_request.booking_id = $scope.booking.id;

        $scope.service_requestForm.$submitted = true;

        if (!$scope.service_requestForm.$valid) {
            return;
        }

        $scope.ajaxPost('saveRequest', {
                service_request: $scope.service_request,
            }, false)
            .then(function(response) {
                if (response.success) {

                    response.booking_service.created_at = new Date(response.booking_service.created_at);
                    $scope.booking_service.push(response.booking_service);
                    $('#addNewServiceRequest').modal('hide');
                    $("#serviceFormBtns").hide();
                    $("#complainFormBtns").show('slow')
                    if ($scope.user_frontdesk) {
                        // window.close();
                    }
                    $scope.service_request = {};
                }
            })
            .catch(function(e) {
                console.log(e);
            });
    }

    $scope.showRequest_Complains = function() {
        $("#showRequest_Complains").modal({
            focus: false
        });
        $("#mycomplain-tab").addClass('active show');
        $("#myrequest-tab").removeClass('active show');
        $("#c_table-tab").addClass('active show');
        $("#r_table-tab").removeClass('active show');

        $('[data-popup="popover"]').popover();
        // $scope.$apply();
    }

    $scope.hideRequest_Complains = function() {
        $("#showRequest_Complains").modal('hide');
    }

    $scope.getStatusClass = function(st) {
        switch (st) {
            case 'Open':
                return 'border-left-grey';
            case 'On Hold':
                return 'border-left-warning';
            case 'Resolved':
                return 'border-left-success';
            case 'Closed':
                return 'border-left-danger';
            case 'Invalid':
                return 'border-left-warning';
            case 'Wontfix':
                return 'border-left-grey';

        }
    }

    $scope.bookingStatus = function(bs) {
        switch (bs) {
            case 'Confirmed':
                return 'badge-info';
            case 'Cancelled':
                return 'badge-danger disabled';
            case 'Pending':
                return 'badge-primary';
            case 'CheckedIn':
                return 'badge-success';
            case 'CheckedOut':
                return 'badge-warning disabled';
        }
    }

    $scope.getBserviceStatus = function(ser_status) {
        switch (ser_status) {
            case 'awaiting':
                return 'badge-warning';
            case 'accepted':
                return 'badge-info';
            case 'cancelled':
                return 'badge-danger';
            case 'completed':
                return 'badge-success';
            case 'rejected':
                return 'badge-danger';
        }
    }

    $scope.getBserIcon = function(ser_status) {
        switch (ser_status) {
            case 'awaiting':
                return 'icon-hour-glass2';
            case 'accepted':
                return 'icon-checkmark';
            case 'cancelled':
                return 'icon-close2 ';
            case 'completed':
                return 'icon-checkmark';
            case 'rejected':
                return 'icon-close2';
        }
    }

    $scope.getBserBorder = function(ser_status) {
        switch (ser_status) {
            case 'awaiting':
                return 'border-left-warning';
            case 'accepted':
                return 'border-left-info';
            case 'cancelled':
                return 'border-left-danger';
            case 'completed':
                return 'border-left-success';
            case 'rejected':
                return 'border-left-danger';
        }
    }


    $scope.bckToMain = function() {
        $("#complainFormBtns").show('slow');
        $("#serviceFormBtns").hide();
    }

    $scope.checkAvailedServices = function() {
        $("#showRequest_Complains").modal({
            focus: false
        });
        $scope.hideServiceModal();

        $('#c_table-tab').parent().hide();
        $('#mycomplain-tab').hide();

        $("#myrequest-tab").addClass('active show');
        $("#r_table-tab").addClass('active show');
    }

    $scope.addOther = function() {
        // add the service just like other services
        $scope.service_requestForm.$submitted = true;

        if (!$scope.service_requestForm.$valid) {
            return;
        }

        let other_service = {
            id: $scope.other_id++,
            Service: $scope.service_request.other_title,
            amount: $scope.service_request.other_charges,
            excludes: 1,
            IconPath: "icon-user",
            is_other: true
        }

        $scope.service_request.services.push(other_service);
        $scope.total_excluded++;

        // clear both variables
        document.getElementById('service_requestForm').reset();

        $scope.service_requestForm.$setPristine();
        $scope.service_requestForm.$setUntouched();

        setTimeout(() => {
            $scope.$apply();
        }, 200);
    }


    $scope.acceptRejectBookingService = function(id, reject_accept) {
        $scope.ajaxPost('accept_booking_service', {
                service_id: id,
                action: reject_accept,
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.hideRequest_Complains();
                }
            })
            .catch(function(e) {
                console.log(e);
            });
    }

    // accept reject from notification bar
    $rootScope.acceptRejectBService = function(id, reject_accept) {
        // return;
        $.post('accept_booking_service', {
            _token: $('meta[name=csrf-token]').attr('content'),
            service_id: id,
            action: reject_accept,
        }).done(function(response) {
            if (response.success) {
                let item = '#service' + response.booking_service.id
                $(item).hide('slow');

            }
        })
    }

    $scope.cancelBookingService = function(id, reason) {
        console.log(id, reason);

        $scope.ajaxPost('cancel_booking_service', {
                service_id: id,
                cancel_reason: reason,
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.hideRequest_Complains();
                }
            })
            .catch(function(e) {
                console.log(e);
            });
    }

    // $scope.getBookingServices = function() {
    //     // if ($scope.user_frontdesk) {
    //     $.get('get_booking_services').done(function(response) {
    //             $rootScope.booking_services = response.booking_services;
    //         })
    //         // }
    // }
    // $scope.getBookingServices();

    // $scope.getBooKingServiceCount = function() {
    //     if ($scope.user_frontdesk) {
    //         $.get('get_booking_services_count').done(function(response) {
    //             $rootScope.booking_services_count = response.booking_services_count;
    //             console.log($rootScope.booking_services.length);

    //             if ($rootScope.booking_services.length != $rootScope.booking_services_count) {
    //                 if ($rootScope.booking_services.length < $rootScope.booking_services_count) {
    //                     $rootScope.new_service_available = true;
    //                     toastr.success("New Service is added!");
    //                 }
    //                 $scope.getBookingServices();
    //             }
    //         })
    //     }
    // }

    // $interval($scope.getBooKingServiceCount, 5000);

    // $rootScope.showNotifications = function() {
    //     $rootScope.new_service_available = false;
    // }





});
app.controller('hotelbookingservicesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {

    //scope variables
    $scope.hotelbookingservices = {};
    $scope.filter = {};
    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0'<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([3, 4]).notSortable()
    ];

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getServiceStatus = function(ser_status) {
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
    $scope.getHotels = function() {
        $scope.ajaxGet('get_hotels', {}, true)
            .then(function(response) {
                $scope.hotels = response.hotels;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.init = function() {
        $scope.getHotelBookingServices('awaiting');
        $scope.getHotels();
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

    $scope.serviceInfoModal = function(booking_service_id) {
        $scope.bookingServiceInfo = $scope.hotelbookingservices.filter((hbs) => hbs.id == booking_service_id)[0];
        console.log($scope.bookingServiceInfo);
    }
    $scope.getHotelBookingServices = function(ser_status) {
        $scope.service_status = ser_status;
        $scope.ajaxPost('get_hotel_booking_services', { status: ser_status }, true)
            .then(function(response) {
                $scope.hotelbookingservices = response.hotelbookingservices;
                $scope.user = response.user;
                if ($scope.user.name == 'Frontdesk') {
                    $scope.filter.hotel_id = $scope.user.hotel_id;
                }
                setTimeout(function() { $('[data-popup="popover"]').popover(); }, 800);
                console.log($scope.user);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.filterBookingServices = function() {
        console.log($scope.filter.hotel_id);
        $scope.ajaxPost('get_filter_booking_services', { hotel_id: $scope.filter.hotel_id }, true)
            .then(function(response) {
                $scope.hotelbookingservices = response.hotelbookingservices;
                console.log($scope.hotelbookingservices);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.acceptRejectBookingService = function(id, reject_accept) {
        console.log(id, reject_accept);
        // return;
        $scope.ajaxPost('accept_reject_booking_service', {
                service_id: id,
                action: reject_accept,
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.getHotelBookingServices('awaiting');
                }
            })
            .catch(function(e) {
                console.log(e);
            });

    }

    $scope.cancelBookingService = function(sid) {
        bootbox.prompt({
            title: 'Please enter a reason for cancellation',
            inputType: 'text',
            minlength: 4,
            callback: function(result) {
                if (result) {
                    $scope.ajaxPost('cancel_booking_service/' + sid, {
                        reason: result,
                        service_id: sid
                    }, false).then(function(response) {
                        if (response.success) {
                            $scope.getHotelBookingServices('accepted');
                        }
                    }).catch(function(e) {});
                }
            }
        });
    }

});
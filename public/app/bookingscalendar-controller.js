app.controller('bookingsCalendarCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    $scope.hotel = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([3, 4]).notSortable()
    ];

    $scope.init = function() {
        $scope.getData();
    }

    $scope.getData = function(date) {
        $scope.ajaxPost('get_bookings_calendar', {
                date: date,
            }, true)
            .then(function(response) {
                $scope.max_count = response.max_count;
                $scope.bookings = response.bookings;
                $scope.booking_counts = response.booking_counts;
                // console.log($scope.booking_counts);
                var keys = Object.keys($scope.booking_counts);
                $scope.events = [];
                for (let i = 0; i < keys.length; i++) {
                    let st = {
                        start: keys[i],
                        end: keys[i],
                        count: $scope.booking_counts[keys[i]],
                        color: $scope.getcolorCode($scope.max_count, $scope.booking_counts[keys[i]]),
                        html: "<div class='booking-counts'><strong class='mr-1'>" + $scope.booking_counts[keys[i]] + "</strong><label>Bookings</label></div>",
                    };
                    $scope.events.push(st);
                }
                loadBookingsInCalendar($scope.events, $scope);
            })
            .catch(function(e) {
                console.log(e);
            })
    }


    $scope.getBookings = function(date) {
        $scope.getData(date);
        $('#eventBookingsModal').modal('show');
    }

    $scope.getMonthsData = function(date) {
        $scope.getData(date);
    }



    // $scope.showEventBookings = function(hotel_id, status, start) {
    //     console.log(hotel_id, status, start);
    //     $scope.ajaxPost('get_event_bookings', {
    //             hotel_id: hotel_id,
    //             status: status,
    //             start: start
    //         }, true)
    //         .then(function(response) {
    //             $scope.event_bookings = response.event_bookings;
    //             $("#eventBookingsModal").modal('show');
    //         })
    //         .catch(function(e) {
    //             console.log(e);
    //         })
    // }


    $scope.showBookingDetail = function(booking_id) {
        // console.log(booking_id);
        let b = parseInt(booking_id);

        $scope.booking_detail_calendar = {};
        $scope.findBooking(b, function() {
            $scope.booking_detail_calendar = $scope.fBooking
            $scope.booking_detail_calendar.customer.LatestBooking = moment($scope.booking_detail_calendar.customer.LatestBooking).format("MM/DD/YYYY");
            $scope.booking_detail_calendar.cBookingFrom = moment($scope.booking_detail_calendar.BookingFrom).format("MM/DD/YYYY");
            $scope.booking_detail_calendar.cBookingTo = moment($scope.booking_detail_calendar.BookingTo).format("MM/DD/YYYY");
            $("#event_detail_row").hide('slow');
            $("#booking_detail_row").show('slow');
            $(".bckbtn").show('slow');
            // console.log($scope.booking_detail_calendar);
        });
    }

    $scope.hideBookingDetail = function() {
        $("#booking_detail_row").hide('slow');
        $(".bckbtn").hide('slow');
        $("#event_detail_row").show('slow');
    }
    $scope.hideEventBookingsModal = function() {
        $("#eventBookingsModal").modal('hide');
    }


    $scope.getBookingStatus = function(status) {
        switch (status) {
            case 'Confirmed':
                return 'bg-info';
            case 'Cancelled':
                return 'bg-danger';
            case 'Pending':
                return 'bg-primary';
            case 'CheckedIn':
                return 'bg-success';
            case 'CheckedOut':
                return 'bg-warning';
        }
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

    $scope.findBooking = function(booking_id, callback) {
        $scope.ajaxGet('bookings/find/' + booking_id, {}, true).then(function(response) {
            if (response.success) {
                $scope.fBooking = response.booking;
                callback();
            }
        })
    }
});
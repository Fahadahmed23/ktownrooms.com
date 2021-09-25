app.controller('hotelDashboardCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.records = {};
    $scope.hotel_dashboard = {
        checkin_period: 'as of today',
        checkout_period: 'as of today',
    };
    // $scope.periods = [
    //     { name: 'Today', },
    //     { name: 'This Week', },
    //     { name: 'Next Week', },
    //     { name: 'This Month', },
    //     { name: 'Next Month', },
    // ];

    $scope.room_ids = [];
    //********************************** FUNCTIONS *******************************// 

    $scope.init = function() {
        $scope.getRecords();
    }

    $scope.getRandomRgb = function() {
        var num = Math.round(0xffffff * Math.random());
        var r = num >> 16;
        var g = num >> 8 & 255;
        var b = num & 255;
        return 'rgb(' + r + ', ' + g + ', ' + b + ')';
    }
    $scope.getCheckInActiveClass = function(period) {
        switch (period) {
            case 'as of today':
                return '.aot-ci';
            case 'this week':
                return '.tw-ci';
            case 'this month':
                return '.tm-ci';
            case 'next week':
                return '.nw-ci';
            case 'next month':
                return '.nm-ci';
        }
    }

    $scope.getCheckins = function(period) {
        $('.cstClassCI').removeClass('active');
        var cls = $scope.getCheckInActiveClass(period);

        // var cls = '.aot-ci';

        $(cls).addClass('active');
        // console.log($scope.hotel_dashboard);
        $scope.ajaxGet('getCheckins', { period: period }, true)
            .then(function(response) {
                $scope.records.expectedCheckinCount = response.expectedCheckinCount;
                $scope.records.todayCheckinCount = response.todayCheckinCount;
                $scope.records.completedCheckinCount = response.completedCheckinCount;
            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.getCheckOutActiveClass = function(period) {
        switch (period) {
            case 'as of today':
                return '.aot-co';
            case 'this week':
                return '.tw-co';
            case 'this month':
                return '.tm-co';
            case 'next week':
                return '.nw-co';
            case 'next month':
                return '.nm-co';
        }
    }
    $scope.getCheckouts = function(period) {
        $('.cstClassCO').removeClass('active');
        var cls = $scope.getCheckOutActiveClass(period);
        $(cls).addClass('active');

        // var cls = '.aot-co';

        $scope.ajaxGet('getCheckouts', { period: period }, true)
            .then(function(response) {
                $scope.records.expectedCheckoutCount = response.expectedCheckoutCount;
                $scope.records.todayCheckoutCount = response.todayCheckoutCount;
                $scope.records.completedCheckoutCount = response.completedCheckoutCount;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.getRecords = function() {
        $scope.ajaxGet('get_hotel_records', {}, true)
            .then(function(response) {
                $scope.records = response;
                $scope.is_admin = response.is_admin;
                $scope.user = response.user;
                $scope.customers = response.customerBookings;
                $scope.channel_bookings = response.channel_bookings;
                $scope.currBooking = response.currBooking;
                $scope.prevBooking = response.prevBooking;
                $scope.open_complains = response.open_complains;
                $scope.discount_requests = response.discount_requests;
                $scope.hotelbookingservices = response.hotelbookingservices;
                $scope.revenueMonthly = response.revenueMonthly;
                $scope.revenueData = [];
                for (let i = 0; i < $scope.revenueMonthly.date.length; i++) {
                    $scope.revenueData.push({ date: $scope.revenueMonthly.date[i], value: $scope.revenueMonthly.value[i] });
                }
                for (let i = 0; i < $scope.discount_requests.length; i++) {
                    $scope.discount_requests[i].created_at = moment($scope.discount_requests[i].created_at).format('MM/DD/YYYY');
                }
                var currentDate = moment().format("MMMM Do, YYYY");
                $scope.current_date = currentDate;

                $scope.channelLabel = [];
                $scope.channelData = [];

                $scope.bookingLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                // $scope.bookingCurrData = [];
                // $scope.bookingPrevData = [];

                setTimeout(() => {
                    var endCheckout = 100;
                    var endCheckin = 100;
                    if ($scope.records.completedCheckoutCount > 0) {

                        endCheckout = ($scope.records.todayCheckoutCount / $scope.records.completedCheckoutCount) * 100;
                    }

                    if ($scope.records.completedCheckinCount > 0) {

                        endCheckin = ($scope.records.todayCheckinCount / $scope.records.completedCheckinCount) * 100;
                    }
                    loadCheckOutStats('#progress_icon_three', 42, 2.5, "#009688", "#009688", endCheckout, "icon-exit3");
                    loadCheckInStats('#progress_icon_four', 42, 2.5, "#673ab7", "#673ab7", endCheckin, "icon-checkmark4");
                    loadBookingStatistics($scope.records, "#pie_progress_bar", 146);
                    loadTotalRevenue($scope.revenueData, "#chart_area_basic", 50, '#5C6BC0');
                    /********* Channel Bookings *********/
                    $scope.channel_bookings.forEach(element => {
                        $scope.channelLabel.push(element.label);
                        $scope.channelData.push(element.count);
                    });
                    var backgroundColor = [];
                    for (var i = 0; i < $scope.channelLabel.length; i++) {
                        backgroundColor.push($scope.getRandomRgb());
                    }
                    var datasets = [{
                        data: $scope.channelData,
                        backgroundColor: backgroundColor
                    }, ];

                    loadChannelBookingsGraph($scope.channelLabel, datasets);
                    /********* Channel Bookings *********/

                    /********* All Bookings *********/
                    var currentBackgroundColor = 'rgb(75, 192, 192)';
                    var prevBackgroundColor = 'rgb(153, 102, 255)';

                    var datasets = [{
                        label: 'Current Year',
                        data: $scope.currBooking,
                        backgroundColor: currentBackgroundColor,
                        borderColor: currentBackgroundColor
                    }, {
                        label: 'Previous Year',
                        data: $scope.prevBooking,
                        backgroundColor: prevBackgroundColor,
                        borderColor: prevBackgroundColor,

                    }];

                    loadAllBookingsGraph($scope.bookingLabel, datasets);
                    /********* All Bookings *********/

                }, 300);

            })
            .catch(function(e) {
                console.log(e);
            })
    }




});
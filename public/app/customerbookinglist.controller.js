app.controller('bookinglistcltr', function($scope, $rootScope, DTColumnDefBuilder, DTOptionsBuilder, $filter, $interval, urlService) {

    $scope.user = {};


    $scope.init = function() {
        // debugger;
        $scope.user;
        $scope.getUsers();
    }

    $scope.getCustomerProfileBooking = function() {
        // debugger;
        $scope.ajaxGet('customer_profile_bookings', {}, true)
            .then(function(response) {
                // debugger;
                $scope.customerbooking = response.bookings;
            })
            .catch(function(e) {
                console.log(e);
            })
    }


    $scope.GetBookingDetails=function(e)
    {
        // debugger;
        $scope.ajaxGet('customer_single_profile_booking/'+e, {}, true)
        .then(function(response) {
            //  debugger;

            $scope.bookingDetails = response;
            $('#Customerbookingmodel').modal();
        })
        .catch(function(e) {
            console.log(e);
        })
    }

});

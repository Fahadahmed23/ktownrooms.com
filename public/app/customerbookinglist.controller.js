app.controller('bookinglistcltr', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {

    $scope.user = {};


    $scope.init = function() {
        debugger;
        $scope.user;
        $scope.getUsers();
    }

    $scope.getCustomerProfileBooking = function() {
        debugger;
        $scope.ajaxGet('customer_profile_bookings', {}, true)
            .then(function(response) {
                debugger;
                $scope.customerbooking = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }


});

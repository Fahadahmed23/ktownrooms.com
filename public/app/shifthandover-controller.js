app.controller('shifthandoverCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.shift_handover = {};
    $scope.formType = "";
    $scope.today = moment().format('MM/DD/YYYY');
    $scope.errors = [];
    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {
        $scope.getShiftHandover();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getShiftHandover = function() {
        $scope.ajaxGet('get_shift_handover', {}, true)
            .then(function(response) {
                $scope.user_opening_balance = response.user_opening_balance;
                $scope.shift_handover.cash_received_today = response.cash_received_today;
                $scope.shift_handover.cash_paid_today = response.cash_paid_today;
                $scope.shift_handover.cash_available = response.cash_available;
                // for drop downs
                $scope.users = response.users;

            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.showshiftHandOverSheet = function() {
        $("#shiftHandOverSheet").show('slow');
    }
    $scope.hideshiftHandOverSheet = function() {
        $("#shiftHandOverSheet").hide('slow');
    }


    $scope.confirmHandover = function(shift_handover) {
        bootbox.confirm({
            title: 'Confirm',
            message: "Are you sure you want to handover shift?",
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
                $scope.handOverShift();
            }
        })

    }

    $scope.handOverShift = function() {
        $scope.shiftHandoverForm.$submitted = true;
        if (!$scope.shiftHandoverForm.$valid) {
            window.scrollTop();
            return;
        }
        console.log($scope.shift_handover);
        $scope.ajaxPost('shift_handover', {
                shift_handover: $scope.shift_handover,
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.init();
                }
            }).catch(function(e) {
                console.log(response);
            })

    }

    $scope.revert = function() {
        $('#addNewAutoPosting').hide('slow');
    }

});
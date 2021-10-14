app.controller('profileCtrl', function($scope) {
    $scope.cred = {};
    $scope.profile = {};

    $scope.init = function() {
        $scope.getProfile();
        $scope.getLeaves();
        $("[data-popup='popover']").popover('hide');
    }

    $scope.leave_types = [
        'sick leave',
        'maternity/paternity',
        'casual leave',
        'personal leave'
    ]
    $scope.getProfile = function() {
        $scope.ajaxPost('getProfile', {}, true)
            .then(function(response) {
                // console.log(response);
                $scope.profile = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.updateProfile = function() {
        $scope.ajaxPost('updateProfile', $scope.profile, false).then(function(response) {
            if (!response.errors) {
                $scope.getProfile();
            }
        })
    }

    $scope.changePassword = function() {
        console.log($scope.cred);
        $scope.ajaxPost('changePassword', $scope.cred).then(function(response) {
            if (!response.errors) {
                $scope.cred = {};
                console.log(response);
            }
        })
    }


    $scope.getLeaves = function() {
        $scope.ajaxPost('get_leaves', {}, true)
            .then(function(response) {
                $scope.leaves = response.leaves;

                for (let i = 0; i < $scope.leaves.length; i++) {
                    $scope.leaves[i].LeaveRequestFrom = moment($scope.leaves[i].LeaveRequestFrom).format('MM/DD/YYYY');
                    $scope.leaves[i].LeaveRequestTo = moment($scope.leaves[i].LeaveRequestTo).format('MM/DD/YYYY');
                }
                $scope.events = [];
                for (let i = 0; i < $scope.leaves.length; i++) {
                    $scope.leaves[i].LeaveRequestFrom = moment($scope.leaves[i].LeaveRequestFrom).format('YYYY-MM-DD');
                    $scope.leaves[i].LeaveRequestTo = moment($scope.leaves[i].LeaveRequestTo).format('YYYY-MM-DD');
                    let st = {
                        title: $scope.leaves[i].type,
                        start: $scope.leaves[i].LeaveRequestFrom,
                        end: $scope.leaves[i].LeaveRequestTo,
                        status: $scope.leaves[i].status,
                        color: "#eee",
                    };
                    // for color changing a/c to status
                    switch ($scope.leaves[i].status) {
                        case "pending":
                            st.color = '#ff5722';
                            break;
                        case "approved":
                            st.color = '#4caf50';
                            break;
                        case "rejected":
                            st.color = "#f44336";
                            break;
                    }
                    $scope.events.push(st);
                }
                loadLeavesInCalendar($scope.events, $scope);
            })
            .catch(function(e) {
                console.log(e);
            })
    }


    $scope.createLeaveRequest = function() {
        $("#leaveRequestFormSec").show('slow');
        $("#basicInfoSec").hide('slow');
    }
    $scope.hideLeaveRequest = function() {
        $("#basicInfoSec").show('slow');
        $("#leaveRequestFormSec").hide();

    }

    $scope.saveLeaveRequest = function() {
        $scope.leaveForm.$submitted = true;
        if (!$scope.leaveForm.$valid) {
            return;
        }
        $scope.leave.LeaveRequestFrom = moment($scope.leave.LeaveRequestFrom).format("YYYY-MM-DD");
        $scope.leave.LeaveRequestTo = moment($scope.leave.LeaveRequestTo).format("YYYY-MM-DD");

        $scope.ajaxPost('leave_request', {
                leave: $scope.leave
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.init();
                    $scope.leave = {};
                    $scope.leaveForm.$setPristine();
                    $scope.leaveForm.$setUntouched();
                }
            }).catch(function(e) {
                console.log(response);
            })
    }
    $scope.getLeaveStatus = function(s) {
        switch (s) {
            case 'pending':
                return 'badge-warning';
            case 'approved':
                return 'badge-success';
            case 'rejected':
                return 'badge-danger';
        }
    }

});
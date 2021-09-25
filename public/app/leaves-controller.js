app.controller('leavesCtrl', function($scope) {
    $scope.leave = {};
    $scope.users = {};
    $scope.statuses = [
            'approved',
            'rejected',
            'pending'
        ]
        // $scope.months = [
        //     { name: 'January', value: 1 },
        //     { name: 'February', value: 2 },
        //     { name: 'March', value: 3 },
        //     { name: 'April', value: 4 },
        //     { name: 'May', value: 5 },
        //     { name: 'June', value: 6 },
        //     { name: 'July', value: 7 },
        //     { name: 'August', value: 8 },
        //     { name: 'September', value: 9 },
        //     { name: 'October', value: 10 },
        //     { name: 'November', value: 11 },
        //     { name: 'December', value: 12 },
        // ]
    $scope.init = function() {
        $scope.getAllLeaves();
        $scope.getUsers();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }
    $scope.getUsers = function() {
        $scope.ajaxGet('all_users', {}, true)
            .then(function(response) {
                $scope.users = response.users;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.jumpTo = function(new_date) {
        if (!new_date)
            new_Date = new Date();
        else
            new_Date = new Date(new_date);
        leaveCalendarSlotsInit.gotoDate(new_Date);
    }
    $scope.getAllLeaves = function(date) {
        $scope.ajaxPost('get_all_leaves', {
                user_id: $scope.user_id,
                date: date
            }, true)
            .then(function(response) {
                $scope.leaves = response.leaves;
                $scope.events = [];
                for (let i = 0; i < $scope.leaves.length; i++) {
                    $scope.leaves[i].LeaveRequestFrom = moment($scope.leaves[i].LeaveRequestFrom).format('YYYY-MM-DD');
                    $scope.leaves[i].LeaveRequestTo = moment($scope.leaves[i].LeaveRequestTo).format('YYYY-MM-DD');
                    var className = $scope.leaves[i].status == 'pending' ? 'cursor' : 'no-cursor'
                    let st = {
                        id: $scope.leaves[i].id,
                        title: $scope.leaves[i].type,
                        start: $scope.leaves[i].LeaveRequestFrom,
                        end: $scope.leaves[i].LeaveRequestTo,
                        status: $scope.leaves[i].status,
                        color: "#eee",
                        className: className,
                        html: "<div class='leave_detail'>" +
                            "<div class='user-name'>" +
                            "<small><b>" + $scope.leaves[i].user.name + "</b></small>" +
                            "</div>"

                            +
                            "<div class='leave-type'>" +
                            "<small>" + "<span>Type: </span>" + $scope.leaves[i].type + "</small>" +
                            "</div>"

                            +
                            "<div class='leave-from'>" +
                            "<small>" + "<span>From : </span>" + $scope.leaves[i].LeaveRequestFrom + "</small>" +
                            "</div>"

                            +
                            "<div class='leave-to'>" +
                            "<small>" + "<span>To : </span>" + $scope.leaves[i].LeaveRequestTo + "</small>" +
                            "</div>"

                            +
                            "<div class='leave-status-name'>" +
                            "<small>" + "<span>Status : </span>" + "<strong class='text-uppercase'>" + $scope.leaves[i].status + "</strong>" + "</small>" +
                            "</div>"

                            +
                            "</div>",

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

    $scope.getMonthsData = function(date) {
        $scope.getAllLeaves(date);
    }

    $scope.showApporveRejectModal = function(leave_id) {
        $scope.leave = angular.copy(Object.values($scope.leaves).find(l => l.id == leave_id));

        $scope.ajaxGet('get_approved_leaves', { user_id: $scope.leave.user_id, }, true)
            .then(function(response) {
                $scope.approved = response.approved;
            })
            .catch(function(e) {
                console.log(e);
            })

        $scope.$apply();


        $("#AprveRejctModal").modal('show');

    }
    $scope.approveRejectLeave = function(leave_id, status) {
        console.log(leave_id, status);
        if (status == "rejected") {
            bootbox.prompt({
                title: 'Please enter a reason for rejection of leave',
                inputType: 'text',
                minlength: 4,
                callback: function(result) {
                    if (result) {
                        $scope.ajaxPost('approve_reject_leave/', {
                            leave_id: leave_id,
                            leave_status: status,
                            reason: result,
                        }, false).then(function(response) {
                            if (response.success) {
                                $scope.init();
                                $scope.hideApproveRejectModal();
                            }
                        }).catch(function(e) {});
                    }
                }
            });
        } else {
            $scope.ajaxPost('approve_reject_leave', {
                    leave_id: leave_id,
                    leave_status: status,
                    rejected_reason: $scope.leave.rejected_reason
                }, false)
                .then(function(response) {
                    if (response.success) {
                        $scope.init();
                        $scope.hideApproveRejectModal();
                    }
                }).catch(function(e) {
                    console.log(response);
                })
        }
    }
    $scope.hideApproveRejectModal = function() {
        $("#AprveRejctModal").modal('hide');
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

    $scope.clearFilter = function() {
        $scope.jumpTo(new Date());
        $scope.user_id = "";
        $scope.init();
    }

});
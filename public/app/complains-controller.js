app.controller('complainsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    $scope.complains = [];
    $scope.complain_statuses = [];
    $scope.priorities = [];
    $scope.departments = [];
    $scope.dates = [];

    // filters
    $scope.filterDate = "";
    $scope.filterStatus = "";
    $scope.filterPriority = "";

    $scope.statusName = "All";
    $scope.priorityName = "All";
    $scope.dateText = "All";

    // sorting
    $scope.sorting_type = "desc";

    // pagination
    $scope.perPage = 10;
    $scope.currentPage = 1;
    $scope.TotalRecords = 0;
    $scope.pagination = [{ page: 1 }];
    $scope.first_time = true;
    $scope.pageSort = {};

    // date-wise grouping
    $scope.current_dates = [];

    // form data models
    $scope.priority = {};

    // booking info
    $scope.Invoice = {};
    $scope.nights = 0;
    $scope.tax_rate = {};

    // functions
    $scope.pageChanged = function(num) {
        $scope.pagination[0].page = num;
        $scope.pageSort = $scope.pagination;
        $scope.getComplains();
    }

    // no use for this till now
    $scope.CustomPagingAndSort = function() {
        ShowLoaderTb();
        let request_data = {
            page: $scope.pagination[0].page,
            perPage: $scope.perPage
        };
        $scope.ajaxGet('getComplains', request_data, true)
            .then(function(response) {
                HideLoaderTb();
                $scope.TotalRecords = response.totalRecords;
                $scope.complains = response.complains;
            });
    }

    $scope.init = function() {
        $scope.loadDateDropdown();
        $scope.pageSort = angular.copy($scope.pagination);
        $scope.getComplains();
        $scope.ajaxGet('complainsData', {}, true).then(function(response) {
            $scope.priorities = response.task_priorities;
            $scope.complain_statuses = response.complain_statuses;
            $scope.departments = response.departments;
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.loadDateDropdown = function() {
        $scope.dates = [];

        $scope.dates.push({
            text: 'Today',
            value: (new moment()).format('YYYY-MM-DD')
        });

        $scope.dates.push({
            text: 'Yesterday',
            value: (new moment()).subtract(1, 'days').format('YYYY-MM-DD')
        });

        $scope.dates.push({
            text: 'This Week',
            value: (new moment()).subtract(1, 'week').format('YYYY-MM-DD')
        });

        $scope.dates.push({
            text: 'This Month',
            value: (new moment()).format('YYYY-MM') + '-01'
        });

        $scope.dates.push({
            text: 'This Year',
            value: (new moment()).format('YYYY') + '-01-01'
        });
    }

    $scope.getComplains = function() {
        let request_data = {
            page: $scope.pagination[0].page,
            perPage: $scope.perPage,
            filters: {
                date_filter: $scope.filterDate,
                status_filter: $scope.filterStatus,
                priority_filter: $scope.filterPriority
            },
            sorting: $scope.sorting_type
        };
        $scope.ajaxGet('getComplains', request_data, true)
            .then(function(response) {
                $scope.complains = response.complains;
                $scope.TotalRecords = response.totalRecords;

                $scope.complains = $scope.complains.map(function(c) {
                    c.ResolveTime = moment(c.ResolveT).format('MM/DD/YYYY hh:mm A');

                    return c;
                });
                $scope.complains = $scope.complains.map(function(c) {
                    c.ComplainTime = moment(c.ComplainT).format('MM/DD/YYYY hh:mm A');

                    return c;
                });

                $scope.groupComplains();

            }).catch(function(e) {
                console.log(e)
            })
    }

    $scope.groupComplains = function() {
        $scope.current_dates = [];

        for (let i = 0; i < $scope.complains.length; i++) {
            let d = moment($scope.complains[i].created_at).format('MMMM DD, YYYY');
            let c = moment();

            // today and yesterday logic
            if (c.diff(moment($scope.complains[i].created_at), 'days') == 0) {
                d = 'Today';
            } else if (c.diff(moment($scope.complains[i].created_at), 'days') == 1) {
                d = 'Yesterday';
            }

            $scope.complains[i].p_date = d;
            if ($scope.current_dates.findIndex((v) => v == d) == -1) {
                $scope.current_dates.push(d);
            }
        }

    }

    $scope.selectPriority = function(c, p) {
        $scope.ajaxPost('complain/setPriority', {
            complain_id: c,
            priority_id: p
        }, false).then(function(response) {
            if (response.success) {
                $scope.getComplains();
            }
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.selectDepartment = function(c, d) {
        $scope.ajaxPost('complain/setDepartment', {
            complain_id: c,
            department_id: d
        }, false).then(function(response) {
            if (response.success) {
                $scope.getComplains();
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.sortByDate = function(s) {
        $scope.sorting_type = s;

        $scope.getComplains();
    }

    $scope.filterByStatus = function(s) {
        $scope.filterStatus = s == '' ? '' : s.id;
        $scope.statusName = s == '' ? 'All' : s.ComplainStatus;

        $scope.getComplains();
    }

    $scope.filterByPriority = function(p) {
        $scope.filterPriority = p == '' ? '' : p.id;
        $scope.priorityName = p == '' ? 'All' : p.TaskPriority;

        $scope.getComplains();
    }

    $scope.filterByDate = function(d) {
        $scope.filterDate = d == '' ? '' : d.value;
        $scope.dateText = d == '' ? 'All' : d.text;

        $scope.getComplains();
    }

    $scope.showInvoice = function(b) {
        $scope.ajaxGet('bookings/find/' + b, {}, true)
            .then(function(response) {
                $scope.Invoice = response.booking;
                $scope.renderInvoice();

            }).catch(function(e) {
                console.log(e);
            })
    }

    $scope.renderInvoice = function() {
        $scope.Invoice.start_date = moment($scope.Invoice.start_date).format('MM/DD/YYYY');
        $scope.Invoice.end_date = moment($scope.Invoice.end_date).format('MM/DD/YYYY');

        $scope.nights = $scope.Invoice.invoice.nights;

        $scope.Invoice.rooms = $scope.Invoice.rooms.map(function(r) {
            r.sub_total = parseFloat(r.pivot.room_charges) + parseFloat(r.pivot.additional_guest_charges);

            return r;
        });

        $scope.tax_rate = $scope.Invoice.tax_rate;

        $('#invoiceBox').modal('show');
    }

    $scope.changeStatus = function(c, s) {
        $scope.ajaxPost('complain/setStatus', {
            complain_id: c,
            status_id: s
        }, false).then(function(response) {
            if (response.success) {
                $scope.getComplains();
            }
        }).catch(function(e) {
            console.log(e);
        })
    }

    $scope.getStatusClass = function(status) {
        switch (status) {
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
});
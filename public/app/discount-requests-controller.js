app.controller('discountrequestsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // user
    $scope.user = {};

    $scope.discount_requests = [];
    $scope.dates = [];

    // filters
    $scope.filterDate = "";
    $scope.filterStatus = "";
    $scope.filterPriority = "";
    $scope.my_request = false;

    $scope.statusName = "Pending";
    $scope.priorityName = "All";
    $scope.dateText = "All";

    // sorting
    $scope.sorting_type = "desc";

    // pagination
    $scope.perPage = 9;
    $scope.currentPage = 1;
    $scope.TotalRecords = 0;
    $scope.pagination = [{ page: 1 }];
    $scope.first_time = true;
    $scope.pageSort = {};
    
    // statuses
    $scope.discount_request_statuses = [
        {id: 1, DiscountRequestStatus: "Approved"},
        {id: 2, DiscountRequestStatus: "Declined"},
        {id: 3, DiscountRequestStatus: "Pending"}
    ];

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
        $scope.getDiscountRequests();
    }


    $scope.init = function() {

        $scope.loadDateDropdown();
        $scope.pageSort = angular.copy($scope.pagination);

        $scope.pathname = window.location.pathname;
        console.log($scope.pathname);
        if ($scope.pathname == '/my_requests') {
            $scope.my_request = true;
            $scope.statusName = "All";
        } else {
            $scope.my_request = false;
            $scope.statusName = "Pending";
        }
        
        $scope.getDiscountRequests();
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

    $scope.getDiscountRequests = function() {
        let request_data = {
            page: $scope.pagination[0].page,
            perPage: $scope.perPage,
            filters: {
                date_filter: $scope.filterDate,
                status_filter: $scope.filterStatus,
                }
                ,
            sorting: $scope.sorting_type
        };
        // $scope.pathname = window.location.pathname;
        // console.log($scope.pathname);
        // if ($scope.pathname == '/my_requests') {
        //     $scope.my_request = true;
        //     $scope.statusName = "All";
        // } else {
        //     $scope.my_request = false;
        //     $scope.statusName = "Pending";
        // }

        $scope.ajaxGet('getDiscountRequests', request_data, true)
            .then(function(response) {
                $scope.discount_requests = response.discount_requests;
                $scope.TotalRecords = response.totalRecords;
                $scope.user = response.user;
                $scope.groupDiscountRequests();

                for (let i = 0; i < $scope.discount_requests.length; i++) {
                    $scope.discount_requests[i].created_at = moment($scope.discount_requests[i].created_at).format('MM/DD/YYYY');
                }

                setTimeout(() => {
                    $('[data-popup="popover"]').popover();
                }, 1500);
                // if($scope.user.name == 'Super Admin' ){
                //     $scope.statusName = "Pending";
                // }else{
                //      $scope.statusName = "All";
                // }

            }).catch(function(e) {
                console.log(e)
            })
    }

    $scope.groupDiscountRequests = function() {
        $scope.current_dates = [];

        for (let i = 0; i < $scope.discount_requests.length; i++) {
            let d = moment($scope.discount_requests[i].created_at).format('MMMM DD, YYYY');
            let c = moment();

            // today and yesterday logic
            if (c.diff(moment($scope.discount_requests[i].created_at), 'days') == 0) {
                d = 'Today';
            } else if (c.diff(moment($scope.discount_requests[i].created_at), 'days') == 1) {
                d = 'Yesterday';
            }

            $scope.discount_requests[i].p_date = d;
            if ($scope.current_dates.findIndex((v) => v == d) == -1) {
                $scope.current_dates.push(d);
            }
        }

    }



    $scope.sortByDate = function(s) {
        $scope.sorting_type = s;

        $scope.getDiscountRequests();
    }

    $scope.filterByDate = function(d) {
        console.log(d);
        $scope.filterDate = d == '' ? '' : d.value;
        $scope.dateText = d == '' ? 'All' : d.text;

        $scope.getDiscountRequests();
    }

    $scope.filterByStatus = function(s) {
        // $scope.filterStatus = s == '' ? '' : s.id;
        $scope.filterStatus = s == '' ? 'All' : s.DiscountRequestStatus;
        $scope.statusName = s == '' ? 'All' : s.DiscountRequestStatus;

        $scope.getDiscountRequests();
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

    $scope.changeStatus = function(d, s) {
        bootbox.prompt({
            title: 'Please enter a reason for updating status',
            inputType: 'text',
            minlength: 50,
            callback: function(result) {
                if (result) 
                {
                    $scope.ajaxPost('discountrequest/setStatus', {
                        discount_request_id: d,
                        status: s,
                        supervisor_comments: result,
                    }, false).then(function(response) {
                        if (response.success) {
                            let item = '#ds_card' + response.discount_request.id;
                           
                            $(item).hide("slow", function (){ 
                                $scope.getDiscountRequests();
                            });
                        }
                    }).catch(function(e) {
                        console.log(e);
                    })
                }
                
            }
        });
    }

    $scope.getStatusClass = function(sc) {
        switch (sc) {
            case 'Pending':
                return 'badge-info text-white';
            case 'Approved':
                return 'badge-success text-white';
            case 'Declined':
                return 'badge-danger text-white disabled ';
        }
    }

    $scope.getStatusClassForBorder = function(sc) {
        switch (sc) {
            case 'Pending':
                return 'border-left-info';
            case 'Approved':
                return 'border-left-success';
            case 'Declined':
                return 'border-left-danger';
        }
    }
});
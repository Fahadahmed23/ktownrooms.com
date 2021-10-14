app.controller('fiscalyearsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.fiscalyears = [];
    $scope.fiscalyear = {};
    $scope.formType = "";
    $scope.errors = [];
    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];


    $scope.statuses = [
        "active",
        "inactive",
        "closed"
    ]

    // functions
    $scope.init = function() {
        $scope.getFiscalYears();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getFiscalYears = function() {
        $scope.ajaxGet('getFiscalYears', {}, true)
            .then(function(response) {
                $scope.fiscalyears = response.fiscalyears;
                console.log($scope.fiscalyears);

                for (let i = 0; i < $scope.fiscalyears.length; i++) {
                    $scope.fiscalyears[i].start_date = moment($scope.fiscalyears[i].start_date).format('MM/DD/YYYY');
                    $scope.fiscalyears[i].end_date = moment($scope.fiscalyears[i].end_date).format('MM/DD/YYYY');
                }


            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createFiscalYear = function() {
        window.scrollTop();
        $scope.fiscalYearForm.$setPristine();
        $scope.fiscalYearForm.$setUntouched();
        $scope.fiscalyear = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#fiscalYearModal').modal('show');
    }


    $scope.editFiscalYear = function(p) {
        window.scrollTop();
        $scope.fiscalYearForm.$setPristine();
        $scope.fiscalYearForm.$setUntouched();
        $scope.fiscalyear = angular.copy(p);
        $scope.formType = "update";
        $('#fiscalYearModal').modal('show');

        console.log($scope.fiscalyear);
    }


    $scope.saveFiscalYear = function() {
        $scope.fiscalYearForm.$submitted = true;
        if (!$scope.fiscalYearForm.$valid) {
            return;
        }

        $scope.fiscalyear.start_date = moment($scope.fiscalyear.start_date).format("YYYY-MM-DD");
        $scope.fiscalyear.end_date = moment($scope.fiscalyear.end_date).format("YYYY-MM-DD");

        let formUrl = $scope.formType == "save" ? 'fiscalyears' : 'fiscalyears/' + $scope.fiscalyear.id;
        $scope.ajaxPost(formUrl, $scope.fiscalyear, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.fiscalyears.push(response.fiscalyear);
                } else {
                    $scope.fiscalyears = $scope.fiscalyears.map((fiscalyear) => fiscalyear.id == $scope.fiscalyear.id ? $scope.fiscalyear : fiscalyear)
                }
                $scope.fiscalyear = {};
                $scope.getFiscalYears();
                $('#fiscalYearModal').modal('hide');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deleteFiscalYear = function(fy) {
        $scope.fiscalyear = angular.copy(fy);
        console.log($scope.fiscalyear);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + fy.FullName + "'?",
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
                if (result) {
                    $scope.ajaxPost('fiscalyears/del', { id: $scope.fiscalyear.id }, false)
                        .then(function(response) {
                            $scope.fiscalyears = $scope.fiscalyears.filter((fiscalyear) => fiscalyear.id != response.id);
                            window.scrollTop();
                            $('#fiscalYearModal').modal('hide');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#fiscalYearModal').modal('hide');
    }


    // $scope.changeStartDate = function() {
    //     let m = moment($scope.fiscalyear.start_date).format('MM/DD/YYYY');
    //     $('#enddate').pickadate('picker').set('min', m);

    //     if (moment(m).diff(moment($scope.fiscalyear.end_date), 'days') > 0)
    //         $scope.fiscalyear.end_date = m;
    // }

    // $scope.changeEndDate = function() {
    //     let m = moment($scope.fiscalyear.end_date).format('MM/DD/YYYY');
    //     $('#startdate').pickadate('picker').set('max', m);

    //     if (moment($scope.fiscalyear.start_date).diff(moment(m)) > 0)
    //         $scope.fiscalyear.start_date = m;
    // }
});
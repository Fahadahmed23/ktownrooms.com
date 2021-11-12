app.controller('generalledgersCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.general_ledgers = [];
    $scope.general_ledger = {};
    $scope.formType = "";
    $scope.selectall = true;
    $scope.errors = [];

    $scope.posting_types = [
        "BS",
        "PL"
    ];

    $scope.dr_cr = [
        "Debit",
        "Credit"
    ];

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
        $scope.getGeneralLedgers();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getAccountType = function(account_type) {

        if (parseInt($scope.general_ledger.account_level_id) == 1) {
            let gl_code = parseInt(account_type.initial_state);
            x = gl_code;

            for (let i = 1; i < parseInt($scope.general_ledger.account_level_id); i++) {
                gl_code += parseInt(account_type.interval);
                x = x + '-' + gl_code;
            }
            $scope.general_ledger.account_gl_code = x;
        } else {
            if (parseInt($scope.general_ledger.account_level_id) > 2) {
                $scope.filtered_general_ledgers = $scope.general_ledgers.filter((gl) => gl.account_level_id < parseInt($scope.general_ledger.account_level_id) && gl.account_type_id == account_type.id);
                console.log($scope.filtered_general_ledgers);


            } else {

                $scope.generateGlCode();
            }


        }

        // for postingtyp autoslect
        $scope.general_ledger.posting_type = account_type.posting_type;

        // for subacount type auto filter
        $scope.filter_account_sub_types = $scope.account_sub_types.filter((s) => s.account_type_id == account_type.id);

    }
    $scope.getParentAccount = function(p) {
        console.log(p);
        $scope.generateGlCode();
    }

    $scope.generateGlCode = function() {
        if ($scope.general_ledger.account_level_id < 5) {
            $scope.ajaxPost('findGLCode', {
                    account_typ: $scope.general_ledger.account_type,
                    parent_acount: $scope.general_ledger.parent_acount,
                    level: parseInt($scope.general_ledger.account_level_id)

                }, true)
                .then(function(response) {
                    if (response.success) {
                        console.log(response.gl_code);
                        $scope.general_ledger.account_gl_code = response.gl_code;
                    }
                })
                .catch(function(e) {
                    console.log(response);
                });
        }

    }


    $scope.filterData = function(searchFields) {
        $scope.filters = angular.copy(searchFields);

        $scope.getGeneralLedgers($scope.filters);
    }

    $scope.getGeneralLedgers = function() {
        $scope.ajaxPost('getGeneralLedgers', {
                filters: $scope.filters,
            }, true)
            .then(function(response) {
                $scope.general_ledgers = response.general_ledgers;
                $scope.filtered_general_ledgers = angular.copy($scope.general_ledgers);

                // for dropdown
                $scope.account_types = response.account_types;
                $scope.account_levels = response.account_levels;
                $scope.account_sub_types = response.account_sub_types;
                $scope.fiscal_years = response.fiscal_years;
                $scope.filter_account_sub_types = angular.copy($scope.account_sub_types);

                console.log($scope.general_ledgers);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createGeneralLedger = function() {
        window.scrollTop();
        $scope.general_ledgerForm.$setPristine();
        $scope.general_ledgerForm.$setUntouched();
        $scope.general_ledger = {};
        $scope.formType = "save";
        window.scrollTop();
        // $('#generalLedgerModal').modal('show');
        $("#addNewgeneralLedger").show('slow');
    }


    $scope.editGeneralLedger = function(gl) {
        window.scrollTop();
        $scope.general_ledgerForm.$setPristine();
        $scope.general_ledgerForm.$setUntouched();
        $scope.general_ledger = angular.copy(gl);

        // for dropdown slection
        $scope.temp_account_type = $scope.account_types.filter((at) => at.id == gl.account_type_id);
        $scope.general_ledger.account_type = $scope.temp_account_type[0];


        // // for parent acoount dropdown show
        // if (gl.account_level_id > 2) {
        //     $(".parent_acount_typ").show('slow');
        // }


        $scope.formType = "update";
        // $('#generalLedgerModal').modal('show');
        $("#addNewgeneralLedger").show('slow');

        console.log($scope.general_ledger);
    }


    $scope.saveGeneralLedger = function() {
        $scope.general_ledgerForm.$submitted = true;
        if (!$scope.general_ledgerForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'general_ledgers' : 'general_ledgers/' + $scope.general_ledger.id;
        $scope.ajaxPost(formUrl, $scope.general_ledger, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.general_ledgers.push(response.general_ledger);
                } else {
                    $scope.general_ledgers = $scope.general_ledgers.map((general_ledger) => general_ledger.id == $scope.general_ledger.id ? $scope.general_ledger : general_ledger)
                }
                $scope.general_ledger = {};
                $scope.getGeneralLedgers();
                // $('#generalLedgerModal').modal('hide');
                $("#addNewgeneralLedger").hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deleteGeneralLedger = function(gl) {
        $scope.general_ledger = angular.copy(gl);
        console.log($scope.general_ledger);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + gl.FullName + "'?",
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
                    $scope.ajaxPost('general_ledgers/del', { id: $scope.general_ledger.id }, false)
                        .then(function(response) {
                            $scope.general_ledgers = $scope.general_ledgers.filter((general_ledger) => general_ledger.id != response.id);
                            window.scrollTop();
                            // $('#generalLedgerModal').modal('hide');
                            $("#addNewgeneralLedger").hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        // $('#generalLedgerModal').modal('hide');
        $("#addNewgeneralLedger").hide('slow');
    }
});
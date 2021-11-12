app.controller('accountlookupsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.account_types = [];
    $scope.account_type = {};

    $scope.account_heads = [];

    $scope.account_sub_types = {};
    $scope.account_sub_type = {}

    $scope.voucher_types = {};
    $scope.voucher_type = {};

    $scope.account_levels = {};
    $scope.account_level = {};

    $scope.account_sales_taxes = {};
    $scope.account_sales_tax = {};

    $scope.formType = "save";


    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0'<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    //********************************** FUNCTIONS *******************************// 

    $scope.init = function() {
        $scope.getAccountLookups();
    }

    $scope.getAccountLookups = function() {
        $scope.ajaxGet('getAccountLookups', {}, true)
            .then(function(response) {
                $scope.account_types = response.account_types;
                $scope.account_sub_types = response.account_sub_types;
                $scope.voucher_types = response.voucher_types;
                $scope.account_levels = response.account_levels;
                $scope.account_sales_taxes = response.account_sales_taxes;

                // for dropdown
                $scope.companies = response.companies;
                $scope.account_heads = response.account_heads;
                console.log(response);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    //for account type 
    $scope.addAccountType = function() {

        $scope.AccountTypeForm.$setPristine();
        $scope.AccountTypeForm.$setUntouched();

        $scope.formType = "save";
        $scope.account_type = {};
        $("#accountTypeModal").modal('show');
    }

    $scope.saveAccountType = function() {

        $scope.AccountTypeForm.$submitted = true;
        if (!$scope.AccountTypeForm.$valid) {
            return;
        }

        $scope.ajaxPost('account/types', { account_type: $scope.account_type, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                $scope.getAccountLookups();
                $('#accountTypeModal').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editAccountType = function(at) {

        $scope.AccountTypeForm.$setPristine();
        $scope.AccountTypeForm.$setUntouched();

        $scope.formType = "edit";
        $scope.account_type = angular.copy(at);
        console.log($scope.account_type);

        $('#accountTypeModal').modal('show');
    }

    $scope.deleteAccountType = function(at) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + at.title + "?",
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
                $scope.ajaxPost('accounts/deleteType', { id: at.id }, false).then(function(response) {
                    $scope.account_types = $scope.account_types.filter((at) => at.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }

    //for account sub type 
    $scope.addAccountSubType = function() {

        $scope.AccountSubTypeForm.$setPristine();
        $scope.AccountSubTypeForm.$setUntouched();

        $scope.formType = "save";
        $scope.account_sub_type = {};
        $("#accountSubTypeModal").modal('show');
    }

    $scope.saveAccountSubType = function() {

        $scope.AccountSubTypeForm.$submitted = true;
        if (!$scope.AccountSubTypeForm.$valid) {
            return;
        }

        $scope.ajaxPost('account/subtypes', { account_sub_type: $scope.account_sub_type, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                $scope.getAccountLookups();
                $('#accountSubTypeModal').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editAccountSubType = function(ast) {

        $scope.AccountSubTypeForm.$setPristine();
        $scope.AccountSubTypeForm.$setUntouched();

        $scope.formType = "edit";
        $scope.account_sub_type = angular.copy(ast);
        console.log($scope.account_sub_type);

        $('#accountSubTypeModal').modal('show');
    }

    $scope.deleteAccountSubType = function(ast) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + ast.title + "?",
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
                $scope.ajaxPost('accounts/deleteSubType', { id: ast.id }, false).then(function(response) {
                    $scope.account_sub_types = $scope.account_sub_types.filter((ast) => ast.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }








    //for voucher type 
    $scope.addVoucherType = function() {

        $scope.VoucherTypeForm.$setPristine();
        $scope.VoucherTypeForm.$setUntouched();

        $scope.formType = "save";
        $scope.voucher_type = {};
        $scope.voucher_type.is_configured = '0';
        $("#voucherTypeModal").modal('show');
    }

    $scope.saveVoucherType = function() {

        $scope.VoucherTypeForm.$submitted = true;
        if (!$scope.VoucherTypeForm.$valid) {
            return;
        }

        $scope.ajaxPost('voucher/types', { voucher_type: $scope.voucher_type, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                $scope.getAccountLookups();
                $('#voucherTypeModal').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editVoucherType = function(vt) {

        $scope.VoucherTypeForm.$setPristine();
        $scope.VoucherTypeForm.$setUntouched();

        $scope.formType = "edit";
        $scope.voucher_type = angular.copy(vt);
        if ($scope.voucher_type.is_configured == '1') {
            $scope.voucher_type.credit_account_type_id = $scope.account_heads.filter((ah) => ah.id == $scope.voucher_type.credit_gl_id)[0].account_type_id;
            $scope.voucher_type.debit_account_type_id = $scope.account_heads.filter((ah) => ah.id == $scope.voucher_type.debit_gl_id)[0].account_type_id;
        }
        console.log($scope.voucher_type);

        $('#voucherTypeModal').modal('show');
    }

    $scope.deleteVoucherType = function(vt) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + vt.title + "?",
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
                $scope.ajaxPost('vouchers/deleteType', { id: vt.id }, false).then(function(response) {
                    $scope.voucher_types = $scope.voucher_types.filter((vt) => vt.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }


    //for account level
    $scope.addAccountLevel = function() {

        $scope.AccountLevelForm.$setPristine();
        $scope.AccountLevelForm.$setUntouched();

        $scope.formType = "save";
        $scope.account_level = {};
        $("#accountLevelModal").modal('show');
    }

    $scope.saveAccountLevel = function() {

        $scope.AccountLevelForm.$submitted = true;
        if (!$scope.AccountLevelForm.$valid) {
            return;
        }

        $scope.ajaxPost('account/levels', { account_level: $scope.account_level, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                $scope.getAccountLookups();
                $('#accountLevelModal').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editAccountLevel = function(al) {

        $scope.AccountLevelForm.$setPristine();
        $scope.AccountLevelForm.$setUntouched();

        $scope.formType = "edit";
        $scope.account_level = angular.copy(al);
        console.log($scope.account_level);

        $('#accountLevelModal').modal('show');
    }

    $scope.deleteAccountLevel = function(al) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + al.name + "?",
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
                $scope.ajaxPost('accounts/deleteLevel', { id: al.id }, false).then(function(response) {
                    $scope.account_levels = $scope.account_levels.filter((al) => al.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }



    //for account sales tax 
    $scope.addAccountSalesTax = function() {

        $scope.AccountSalesTaxForm.$setPristine();
        $scope.AccountSalesTaxForm.$setUntouched();

        $scope.formType = "save";
        $scope.account_sales_tax = {};
        $("#accountSalesTaxModal").modal('show');
    }

    $scope.saveAccountSalesTax = function() {

        $scope.AccountSalesTaxForm.$submitted = true;
        if (!$scope.AccountSalesTaxForm.$valid) {
            return;
        }

        $scope.ajaxPost('account/salestax', { account_sales_tax: $scope.account_sales_tax, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                $scope.getAccountLookups();
                $('#accountSalesTaxModal').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editAccountSalesTax = function(st) {

        $scope.AccountSalesTaxForm.$setPristine();
        $scope.AccountSalesTaxForm.$setUntouched();

        $scope.formType = "edit";
        $scope.account_sales_tax = angular.copy(st);
        console.log($scope.account_sales_tax);

        $('#accountSalesTaxModal').modal('show');
    }

    $scope.deleteAccountSalesTax = function(st) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + st.title + "?",
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
                $scope.ajaxPost('accounts/deleteSalesTax', { id: st.id }, false).then(function(response) {
                    $scope.account_sales_taxes = $scope.account_sales_taxes.filter((st) => st.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }

});
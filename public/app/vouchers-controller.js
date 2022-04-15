app.controller('vouchersCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.vouchers = [];
    $scope.voucher = {};
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

    // functions
    $scope.init = function() {
        $scope.getVouchers();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getVoucherDate = function() {
        $scope.voucher.date = moment($scope.voucher.date).format('MM/DD/YYYY');
    }

    $scope.getVoucherType = function(vid) {
        $scope.vt = $scope.voucher_types.filter((v) => v.id == vid);
        console.log($scope.vt);
        let abr = $scope.vt[0].abbreviation;
        // for temp purpose to show the voucher num
        let d = new Date();
        let current_year = d.getFullYear();

        $scope.voucher.voucher_no = abr + '-' + current_year + '-XXX';
        console.log($scope.voucher.voucher_no);


        if ($scope.vt[0].is_configured == '1') {
            $scope.voucher.is_configured = '1';
        } else {
            $scope.voucher.is_configured = '0';
        }
    }


    $scope.getVouchers = function() {
        $scope.ajaxGet('getVouchers', {}, true)
            .then(function(response) {
                $scope.vouchers = response.vouchers;

                // for drop downs
                $scope.hotels = response.hotels;
                $scope.account_types = response.account_types;
                $scope.account_heads = response.account_heads;
                $scope.voucher_types = response.voucher_types;
                $scope.fiscal_years = response.fiscal_years;
                console.log($scope.vouchers);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createVoucher = function() {

        window.scrollTop();
        $scope.voucherForm.$setPristine();
        $scope.voucherForm.$setUntouched();
        $scope.voucher = {};
        $scope.voucher_detail = {};
        // $scope.voucher.current_fiscal_year = $scope.getfiscalyear;
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewVoucher').show('slow');
        $("#demo2").addClass('show');
        $scope.voucher_details = [];
        $('.vd_push_btn').prop('disabled', true);

        $scope.dr_total = 0;
        $scope.cr_total = 0;
        $scope.voucher.is_configured = '0';
        $scope.field_disabled = false;
        if ($scope.hotels.length == 1) {
            $scope.voucher.hotel_id = $scope.hotels[0].id;

        }
    }

    $scope.editVoucher = function(v) {
        window.scrollTop();
        $scope.voucherForm.$setPristine();
        $scope.voucherForm.$setUntouched();
        $scope.voucher = angular.copy(v);
        $scope.voucher_detail = {};
        $scope.formType = "update";
        $('#addNewVoucher').show('slow');
        $("#demo2").addClass('show');
        console.log($scope.voucher);
        $scope.voucher.date = moment($scope.voucher.date).format('MM/DD/YYYY');
        $scope.voucher_details = $scope.voucher.voucher_details;
        for (let i = 0; i < $scope.voucher_details.length; i++) {
            $scope.voucher_details[i].account_type_name = $scope.voucher_details[i].account_head.account_type.title
        }
        // let acc_head_ids = [];
        // for (let i = 0; i < $scope.voucher_details.length; i++) {
        //     acc_head_ids.push($scope.voucher_details[i].account_gl_id);
        //     $scope.account_type_ids = $scope.account_heads.filter((ah) => ah.id === acc_head_ids[0]).account_type_id;
        // }
        console.log($scope.account_type_ids);
        $scope.calculate_total_dr_cr($scope.voucher.voucher_details);
        $('.vd_push_btn').prop('disabled', true);
        $scope.voucher.is_configured = '0';
        if ($scope.voucher.post == 'approved') {
            $scope.field_disabled = true;
        } else {
            $scope.field_disabled = false;
        }
    }

    $scope.getAccountHead = function(ah) {
        $(".vd_push_btn").prop('disabled', false)
    }

    $scope.calculate_total_dr_cr = function(collections) {
        $scope.dr_total = 0;
        $scope.cr_total = 0;
        collections.forEach(function(item) {
            $scope.dr_total += parseInt(item['dr_amount']);
            $scope.cr_total += parseInt(item['cr_amount']);
        });
    }


    $scope.getDebitVal = function(d_val) {
        d_val = parseInt(d_val);
        if (!isNaN(d_val) && d_val > 0) {
            $(".credit-input").prop('readonly', true);

        } else {
            $(".credit-input").prop('readonly', false);
        }
    }

    $scope.getCreditVal = function(c_val) {
        c_val = parseInt(c_val);
        if (!isNaN(c_val) && c_val > 0) {
            $(".debit-input").prop('readonly', true);
        } else {
            $(".debit-input").prop('readonly', false);
        }
    }

    $scope.test = function(c) {

    }

    $scope.pushVoucherDetail = function(voucher_detail) {
        if ($scope.formType == 'update') {
            $scope.ajaxPost('voucher_detail/add', {
                    voucher_detail: voucher_detail,
                    voucher_master_id: $scope.voucher.id,
                }, false)
                .then(function(response) {
                    // $scope.getVouchers();
                    response.voucher_detail.account_type_name = $scope.account_types.find((at) => at.id === voucher_detail.account_type_id).title;
                    $scope.voucher_details.push(response.voucher_detail);
                    $scope.calculate_total_dr_cr($scope.voucher_details);
                    $scope.voucher.is_configured = '0';
                })
                .catch(function(e) {
                    toastr.error(e);
                })
        } else {

            console.log(voucher_detail);
            if (voucher_detail.cr_amount == undefined) {
                voucher_detail.cr_amount = 0;
            }
            if (voucher_detail.dr_amount == undefined) {
                voucher_detail.dr_amount = 0;
            }
            let vd = $scope.account_heads.filter((ah) => ah.id == voucher_detail.account_gl_id);
            voucher_detail.AccountHeadName = vd[0].title;
            voucher_detail.AccountHeadCode = vd[0].account_gl_code;

            // $scope.voucher_details.push(angular.copy(voucher_detail));
            voucher_detail.account_type_name = $scope.account_types.find((at) => at.id === voucher_detail.account_type_id).title;

            $scope.voucher_details.push(voucher_detail);
            $scope.calculate_total_dr_cr($scope.voucher_details);
        }

        $(".debit-input").prop('readonly', false);
        $(".credit-input").prop('readonly', false);
        $scope.voucher_detail = {};
    }

    $scope.removeVoucherDetail = function(i, vd) {
        if ($scope.formType == 'save') {
            console.log($scope.voucher_details[i]);
            $scope.voucher_details.splice(i, 1);
        } else {
            console.log(vd);
            bootbox.confirm({
                title: 'Confirm Deletion',
                message: "Are you sure you want to delete '" + vd.AccountHeadName + ' (' + vd.AccountHeadCode + ') ' + "'?",
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
                        $scope.ajaxPost('voucher_detail/del', { id: vd.id }, false)
                            .then(function(response) {
                                // $scope.getVouchers();
                                // $('#addNewVoucher').hide('slow');
                                $scope.voucher_details.splice(i, 1);
                                $scope.calculate_total_dr_cr($scope.voucher_details);
                                $scope.voucher.is_configured = '0';
                            })
                            .catch(function(e) {
                                toastr.error(e);
                            })
                    }
                }
            });

        }

    }




    $scope.saveVoucher = function() {

        if ((parseInt($scope.dr_total) - parseInt($scope.cr_total)) != 0) {
            toastr.error('Debit amount should be equal to Credit amount');
            return;
        }

        $scope.voucher.voucher_details = $scope.voucher_details;

        $scope.voucher.date = moment($scope.voucher.date).format("YYYY-MM-DD");

        $scope.voucherForm.$submitted = true;
        if (!$scope.voucherForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'vouchers' : 'vouchers/' + $scope.voucher.id;
        $scope.ajaxPost(formUrl, $scope.voucher, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.vouchers.push(response.voucher);
                } else {
                    $scope.vouchers = $scope.vouchers.map((voucher) => voucher.id == $scope.voucher.id ? $scope.voucher : voucher)
                }
                $scope.voucher = {};
                $scope.getVouchers();
                $('#addNewVoucher').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deleteVoucher = function(v) {
        $scope.voucher = angular.copy(v);
        console.log($scope.voucher);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + v.voucher_no + "'?",
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
                    $scope.ajaxPost('vouchers/del', { id: $scope.voucher.id }, false)
                        .then(function(response) {
                            $scope.vouchers = $scope.vouchers.filter((voucher) => voucher.id != response.id);
                            window.scrollTop();
                            $('#addNewVoucher').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }
    $scope.revert = function() {
        $('#addNewVoucher').hide('slow');
    }

    $scope.getPostedVouchers = function() {
        $scope.ajaxGet('getPostedVouchers', {}, true)
            .then(function(response) {
                $scope.posted_vouchers = response.posted_vouchers;
                console.log($scope.posted_vouchers);
            })
            .catch(function(e) {
                console.log(e);
            })
    }



    $scope.approveVoucher = function(pv) {
        bootbox.confirm({
            title: 'Confirm',
            message: "Are you sure you want to approve this '" + pv.voucher_no + " voucher'?",
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
                    $scope.ajaxPost('voucher_approve', { id: pv.id }, false)
                        .then(function(response) {
                            $scope.getPostedVouchers();
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.detailVoucher = function(pv) {
        console.log(pv);
        $scope.posted_voucher = angular.copy(pv);
        $scope.calculate_total_dr_cr(pv.voucher_details);
        $("#voucherDetailModal").modal('show');
    }




});
app.controller('customersCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.customers = [];
    $scope.customer = {};
    $scope.formType = "";
    $scope.errors = [];
    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row m-0 p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {
        $scope.getCustomers();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getCustomers = function() {
        $scope.ajaxGet('getCustomers', {}, true)
            .then(function(response) {
                $scope.customers = response.customers;
                $scope.nationalities = response.nationalities;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createCustomer = function() {
        window.scrollTop();
        $scope.customerForm.$setPristine();
        $scope.customerForm.$setUntouched();
        $scope.customer = {};
        $scope.customer.is_cnic = 1;
        $scope.customer.nationality = 'Pakistani';
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewCustomer').show('slow');
    }


    $scope.editCustomer = function(c) {
        window.scrollTop();
        $scope.customerForm.$setPristine();
        $scope.customerForm.$setUntouched();
        $scope.customer = angular.copy(c);
        $scope.customer.nationality = 'Pakistani';

        iti.setCountry(($scope.customer.iso).toString());
        iti.setNumber(($scope.customer.Phone).toString());

        $scope.formType = "update";
        $('#addNewCustomer').show('slow');
        $(".customer_stats").show('slow');
        console.log($scope.customer);
    }


    $scope.blackListCustomer = function(c) {
        console.log(c);

        $scope.customer = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to blacklist this '" + c.FirstName + "'?",
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
                    $scope.ajaxPost('customer/blacklist', { id: $scope.customer.id }, false)
                        .then(function(response) {
                            if (response.success) {
                                $('#addNewCustomer').hide('slow');
                            }
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });

    }

    $scope.saveCustomer = function() {

        // $scope.customer.Phone = iti.getNumber();
        // $scope.customer.Phone = iti.getNumber(intlTelInputUtils.numberFormat.E164);
        $scope.customer.iso = iti.selectedCountryData.iso2;

        $scope.customerForm.$submitted = true;
        if (!$scope.customerForm.$valid) {
            return;
        }




        let formUrl = $scope.formType == "save" ? 'customers' : 'customers/' + $scope.customer.id;
        $scope.ajaxPost(formUrl, $scope.customer, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.customers.push(response.cutomer);
                } else {
                    $scope.customers = $scope.customers.map((customer) => customer.id == $scope.customer.id ? $scope.customer : customer);
                }
                $scope.customer = {};
                $scope.getCustomers();
                $('#addNewCustomer').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deleteCustomer = function(c) {
        $scope.customer = angular.copy(c);
        console.log($scope.customer);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.FirstName + "'?",
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
                    $scope.ajaxPost('customers/del', { id: $scope.customer.id }, false)
                        .then(function(response) {
                            $scope.customers = $scope.customers.filter((customer) => customer.id != response.id);
                            window.scrollTop();
                            $('#addNewCustomer').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewCustomer').hide('slow');
    }
    $scope.getcustomer = function(c) {
        applyMask();
        switch (c) {
            case 1:
                return 'cnic';
            case 0:
                return 'alpha_numeric';
        }
    }

});
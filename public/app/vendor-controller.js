app.controller('vendorCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.vendors = [];
    $scope.vendor = {};

    $scope.formType = "";
    // $scope.errors = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0'<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {
        $scope.getVendors();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.viewCreate = function() {
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();
        $scope.formType = "save";

        // console.log($scope.refType);
        // console.log($scope.expType);
        $("#vendorFormSec").show('slow');
    }
    $scope.hideCreate = function() {
        $("#vendorFormSec").hide('slow');
    }

    $scope.saveVendor = function() {
        $scope.myForm.$submitted = true;

        if (!$scope.myForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'vendors' : 'vendors/' + $scope.vendor.id;

        $scope.ajaxPost(formUrl, $scope.vendor, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    if (response.success == true) {
                        $scope.myForm.$setPristine();
                        $scope.myForm.$setUntouched();
                        $scope.vendors.push(response.vendor);
                        $scope.vendor = {};
                        $("#vendorFormSec").hide('slow');
                    }
                } else {
                    if (response.success == true) {
                        $scope.myForm.$setPristine();
                        $scope.myForm.$setUntouched();
                        $scope.vendors = $scope.vendors.map((vendor) => vendor.id == response.vendor.id ? response.vendor : vendor);
                        $scope.vendor = {};
                        $("#vendorFormSec").hide('slow');
                    }
                }


            })
            .catch(function(e) {
                toastr.error(e);
            });
    }


    $scope.editVendor = function(p) {
        window.scrollTop();
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();
        $scope.vendor = angular.copy(p);
        $scope.formType = "update";
        $('#vendorFormSec').show('slow');

        console.log($scope.vendor);
    }


    $scope.getVendors = function(searchFields = {}) {
        $scope.ajaxPost('getVendors', searchFields, true)
            .then(function(response) {
                $scope.vendors = response.vendors;
            })
            .catch(function(e) {
                // console.log(e);
            })
    }

    $scope.searchFilter = function(searchFields) {
        $scope.getVendors(searchFields);
    }

    // $scope.resetFilters = function() {
    //     $scope.searchAttribute = {};
    //     // $scope.searchEmail = "";
    //     // $scope.searchPhone = "";

    //     $scope.getVendors();
    // }

    $scope.revert = function() {
        $('#addNewInventory').hide('slow');
    }
});
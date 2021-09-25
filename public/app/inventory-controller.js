app.controller('inventoryCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.inventories = [];
    $scope.inventory = {};
    $scope.formType = "";
    $scope.errors = [];

    $scope.searchTitle = "";
    $scope.searchRate = "";
    $scope.searchHotel = "";
    $scope.searchDescription = "";

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
        $scope.getInventories();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getInventories = function(searchFields = {}) {
        $scope.ajaxPost('getInventories', searchFields, true)
            .then(function(response) {
                $scope.inventories = response.inventories;
                $scope.user = response.user;
                $scope.is_admin = response.is_admin;
                // for dropdown
                $scope.hotels = response.hotels;
            })
            .catch(function(e) {
                // console.log(e);
            })
    }

    $scope.createInventory = function() {
        window.scrollTop();
        $scope.inventoryForm.$setPristine();
        $scope.inventoryForm.$setUntouched();
        $scope.inventory = {};

        if (!$scope.is_admin) {
            $scope.inventory.hotel_id = $scope.user.hotel_id;
        }
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewInventory').show('slow');
    }

    $scope.clearPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        if (r == "inventory") {
            $scope.inventory.thumbnail = null;
        } else {
            $scope.inventory.thumbnail = null;
        }
    }


    $scope.editInventory = function(p) {
        window.scrollTop();
        $scope.inventoryForm.$setPristine();
        $scope.inventoryForm.$setUntouched();
        $scope.inventory = angular.copy(p);
        $scope.formType = "update";
        $('#addNewInventory').show('slow');

        console.log($scope.inventory);
    }


    $scope.saveInventory = function() {
        $scope.inventoryForm.$submitted = true;
        if (!$scope.inventoryForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'inventory' : 'inventory/' + $scope.inventory.id;
        $scope.ajaxPost(formUrl, $scope.inventory, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.inventories.push(response.inventory);
                } else {
                    $scope.inventories = $scope.inventories.map((inventory) => inventory.id == $scope.inventory.id ? $scope.inventory : inventory)
                }
                $scope.inventory = {};
                $scope.getInventories();
                $('#addNewInventory').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deleteInventory = function(p) {
        $scope.inventory = angular.copy(p);
        console.log($scope.inventory);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + p.FullName + "'?",
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
                    $scope.ajaxPost('inventory/del', { id: $scope.inventory.id }, false)
                        .then(function(response) {
                            $scope.inventories = $scope.inventories.filter((inventory) => inventory.id != response.id);
                            window.scrollTop();
                            $('#addNewInventory').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.searchFilter = function(searchFields) {
        $scope.getInventories(searchFields);
    }

    $scope.revert = function() {
        $('#addNewInventory').hide('slow');
    }
});
app.controller('roomcategoryCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.roomcategories = [];
    $scope.formType = "";
    $scope.filterSearchText = "";

    $scope.facilities = {};
    //$scope.errors = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {
        $scope.getRoomCategories();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }
    $scope.checkFacility = function(facility) {
        // console.log($scope.user.roles);
        let idx = $scope.roomcategory.facilities.indexOf(facility.id);

        if (idx > -1) {
            $scope.roomcategory.facilities = $scope.roomcategory.facilities.filter((f) => f != facility.id);
        } else {
            $scope.roomcategory.facilities.push(facility.id);
        }

        console.log($scope.roomcategory.facilities);
    }
    $scope.getRoomCategories = function() {
        $scope.ajaxGet('getrCategories', {}, true)
            .then(function(response) {

                console.log(response);
                $scope.roomcategories = response.roomcategories;

                // for dropdown
                $scope.facilities = response.facilities;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.editRoomCategory = function(c) {
        window.scrollTop();
        $scope.roomcategoryForm.$setPristine();
        $scope.roomcategoryForm.$setUntouched();

        $('#addNewRoomCategory').show('slow');
        $('#searchRoomCategory').hide();
        $scope.roomcategory = angular.copy(c);
        // for checked the facilities
        console.log(c);
        $scope.roomcategory.facilities = $scope.roomcategory.facilities.map((f) => f.id);

        console.log($scope.roomcategory);
        $scope.formType = "update";


    }


    $scope.createRoomCategory = function() {
        $scope.roomcategoryForm.$setPristine();
        $scope.roomcategoryForm.$setUntouched();

        $scope.roomcategory = {
            facilities: []
        };
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRoomCategory').show('slow');
        $('#searchRoomCategory').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveRoomCategory = function() {

        $scope.roomcategoryForm.$submitted = true;
        if (!$scope.roomcategoryForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'rcategories' : 'rcategories/' + $scope.roomcategory.id;

        $scope.ajaxPost(formUrl, $scope.roomcategory, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.roomcategories.push(response.roomcategory);
                } else {
                    $scope.roomcategories = $scope.roomcategories.map((roomcategory) => roomcategory.id == $scope.roomcategory.id ? response.roomcategory : roomcategory)
                }

                $scope.roomcategory = {};
                $('#addNewRoomCategory').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });
    }

    $scope.deleteRoomCategory = function(c) {
        $scope.roomcategory = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.RoomCategory + "'?",
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
                    $scope.ajaxPost('rcategories/del', { id: $scope.roomcategory.id }, false)
                        .then(function(response) {
                            $scope.roomcategories = $scope.roomcategories.filter((roomcategory) => roomcategory.id != response.id);

                            window.scrollTop();
                            $('#addNewRoomCategory').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewRoomCategory').hide('slow');
    }
});
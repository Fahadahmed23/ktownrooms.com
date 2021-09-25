app.controller('roomcategoriesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.roomcategories = [];

    $scope.roomcategory = {};

    $scope.formType = "";

    $scope.filterSearchText = "";

    //$scope.errors = [];

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

        $scope.getRoomCategories();
    }

    $scope.getRoomCategories = function() {
        $scope.ajaxGet('getRoomCategories', {}, true)
            .then(function(response) {
                $scope.roomcategories = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.editRoomCategory = function(c) {
        $scope.roomcategory = angular.copy(c);
        $scope.formType = "update";

        $('#addNewRoomCategory').show('slow');
        $('#searchRoomCategory').hide();
    }


    $scope.createRoomCategory = function() {
        $scope.roomcategory = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRoomCategory').show('slow');
        $('#searchRoomCategory').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveRoomCategory = function() {
        let formUrl = $scope.formType == "save" ? 'roomcategories' : 'roomcategories/' + $scope.roomcategory.id;

        $scope.ajaxPost(formUrl, $scope.roomcategory, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.roomcategories.push(response.roomcategory);
                } else {
                    $scope.roomcategories = $scope.roomcategories.map((roomcategory) => roomcategory.id == $scope.roomcategory.id ? $scope.roomcategory : roomcategory)
                }

                $scope.roomcategory = {};
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
                    $scope.ajaxPost('roomcategories/del', { id: $scope.roomcategory.id }, false)
                        .then(function(response) {
                            $scope.roomcategories = $scope.roomcategories.filter((roomcategory) => roomcategory.id != response.id);
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
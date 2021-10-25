app.controller('roomsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.rooms = [];
    $scope.room = {};

    $scope.roomtypes = [];
    $scope.roomtype = {};

    $scope.roomcategories = [];
    $scope.roomcategory = {};

    $scope.taxrates = [];
    $scope.taxrate = {};

    $scope.hotel = [];
    $scope.hotels = {};
    $scope.facilities = {};
    $scope.formType = "";

    $scope.filterSearchText = "";

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

            $scope.getRooms();
            // $scope.getRoomTypes();
            // $scope.getRoomCategories();
            // $scope.getTaxRates();
        }
        // $scope.getHotels = function() {
        //     $scope.ajaxGet('getHotels', {}, true)
        //         .then(function(response) {
        //             console.log(response.hotels);
        //             $scope.hotels = response.hotels;
        //         })
        //         .catch(function(e) {
        //             console.log(e);
        //         })
        // }


    $scope.getRooms = function() {

        $scope.ajaxGet('getRooms', {}, true)
            .then(function(response) {
                console.log(response);
                $scope.rooms = response.rooms;

                // for dropdown
                $scope.hotels = response.hotels;
                $scope.roomtypes = response.roomtypes;
                $scope.roomcategories = response.roomcategories;
                $scope.taxrates = response.taxrates;
                $scope.facilities = response.facilities;

            })
            .catch(function(e) {
                console.log(e);
            })
    }

    // $scope.checkFacility = function(id) {
    //     // console.log($scope.user.roles);
    //     let idx = $scope.room.facility.indexOf(id);

    //     if (idx > -1) {
    //         $scope.room.facility.splice(idx, 1);
    //     } else {
    //         $scope.room.facility.push(id);
    //     }

    //     console.log($scope.room.facility);
    // }

    // $scope.getRoomTypes = function() {
    //     $scope.ajaxGet('getRoomTypes', {}, true)
    //         .then(function(response) {
    //             $scope.roomtypes = response;
    //         })
    //         .catch(function(e) {
    //             console.log(e);
    //         })
    // }
    // $scope.getRoomCategories = function() {
    //     $scope.ajaxGet('getRoomCategories', {}, true)
    //         .then(function(response) {
    //             $scope.roomcategories = response;
    //         })
    //         .catch(function(e) {
    //             console.log(e);
    //         })
    // }

    // $scope.getTaxRates = function() {
    //     $scope.ajaxGet('getTaxRates', {}, true)
    //         .then(function(response) {
    //             $scope.taxrates = response;
    //         })
    //         .catch(function(e) {
    //             console.log(e);
    //         })
    // }
    $scope.editRoom = function(c) {
        $scope.room = angular.copy(c);
        $scope.formType = "update";

        $('#addNewRoom').show('slow');
        // $('#searchRoom').hide();
    }


    $scope.createRoom = function() {
        $scope.room = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRoom').show('slow');
        $('#roomTable').hide();

    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveRoom = function() {
        let formUrl = $scope.formType == "save" ? 'rooms' : 'rooms/' + $scope.room.id;
        $scope.ajaxPost(formUrl, $scope.room, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.rooms.push(response.room);
                } else {
                    $scope.rooms = $scope.rooms.map((room) => room.id == $scope.room.id ? $scope.room : room)
                }
                $scope.getRooms();
                $scope.room = {};
            })
            .catch(function(e) {
                console.log(response);
            });
    }

    $scope.deleteRoom = function(c) {
        $scope.room = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.RoomName + "'?",
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
                    $scope.ajaxPost('rooms/del', { id: $scope.room.id }, false)
                        .then(function(response) {
                            $scope.rooms = $scope.rooms.filter((room) => room.id != response.id);
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewRoom').hide('slow');
    }
});
app.controller('roomCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.rooms = [];
    $scope.roomtypes = {};
    $scope.roomcategories = {};
    $scope.hotelroomcategories = {};
    // $scope.taxrates = {};
    $scope.hotels = {};
    $scope.facilities = {};
    $scope.services = [];
    $scope.formType = "";
    $scope.room = {};
    $scope.room.images = {};

    console.log($scope.room);
    $scope.servicetemp = [];
    $scope.temp_room_categories = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row  m-0'<'col-sm-12'tr>>" +
            "<'row p-2  m-0'<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    $scope.init = function() {
        $scope.getnRooms();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.clearPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        if (r == "room") {
            $scope.room.thumbnail = null;
        } else {
            $scope.room.thumbnail = null;
        }
    }

    $scope.clearRoomImage = function(r) {
        $scope.room.images = $scope.room.images.filter((i) => i.id != r.id);
        // // document.getElementById('fileLabel').innerHTML = "";
        // if (r == "image") {
        //     // console.log();
        //     // $scope.roo
        //     $scope.room.images = $scope.room.images.filter((i) => i.id != r.id);

        // } 
        // else {
        //     $scope.room.images = null;
        // }
    }

    $scope.checkFacility = function(facility) {
        let idx = $scope.room.facilities.indexOf(facility.id);
        if (idx > -1) {
            $scope.room.facilities = $scope.room.facilities.filter((f) => f != facility.id);
        } else {
            $scope.room.facilities.push(facility.id);
        }

        console.log($scope.room.facilities);
    }

    // $scope.roomcategoryChange = function() {
    //     let c = $scope.roomcategories.filter((c) => c.id == $scope.room.room_category_id);
    //     $scope.room.facilities = c[0].facilities.map((f) => f.id);
    //     console.log($scope.room);
    // }


    $scope.getHotelId = function(hid) {
        let current_hotel = $scope.hotels.filter((h) => h.id == hid);
        // Equivalent Code filter
        // let a = [];
        // for (let i = 0; i < $scope.hotels.length; i++) {
        //     if ($scope.hotels[i].id == hid) {
        //         a.push($scope.hotels[i]);
        //     }
        // }

        $scope.roomcategories = current_hotel[0].hotelroomcategories.map(function(hrc) {
            return {
                id: hrc.room_category_id,
                RoomCategory: hrc.room_category.RoomCategory
            };
        });

        // Equivalent Code of map
        // let b = [];
        // for (let i = 0; i < current_hotel[0].hotelroomcategories.length; i++) {
        //     b.push({
        //         id: current_hotel[0].hotelroomcategories[i].room_category_id,
        //         RoomCategory: current_hotel[0].hotelroomcategories[i].room_category.RoomCategory
        //     });
        // }

        if ($scope.roomcategories.length < 1) {
            $scope.roomcategories = angular.copy($scope.temp_room_categories);
        }



    }




    $scope.getnRooms = function() {

        $scope.ajaxGet('getnRooms', {}, true)
            .then(function(response) {
                // console.log(response.rooms);
                $scope.rooms = response.rooms;
                $scope.user = response.user;
                $scope.is_admin = response.is_admin;
                // for dropdown
                $scope.services = response.services;
                $scope.hotels = response.hotels;
                $scope.roomtypes = response.roomtypes;
                $scope.roomcategories = response.roomcategories;
                $scope.temp_room_categories = response.roomcategories;
                $scope.hotelroomcategories = response.hotelroomcategories
                    // $scope.taxrates = response.taxrates;
                $scope.facilities = response.facilities;

            })
            .catch(function(e) {
                console.log(e);
            })
    }


    $scope.editRoom = function(c) {
        $scope.roomForm.$setPristine();
        $scope.roomForm.$setUntouched();

        window.scrollTop();
        $scope.room = {};
        $scope.formType = "update";
        $('#addNewRoom').show('slow');
        $('#searchRoom').hide();

        $scope.room = angular.copy(c);
        console.log(c);
        for (let i = 0; i < $scope.services.length; i++) {
            $scope.servicetemp[$scope.services[i].id] = {
                id: $scope.services[i].id,
                status: false,
                // count: 1
            };
        }

        for (let i = 0; i < $scope.room.services.length; i++) {
            $scope.servicetemp[$scope.room.services[i].id] = {

                id: $scope.room.services[i].id,
                status: true,
                // count: $scope.room.services[i].pivot.limit
            };
        }
        $scope.room.is_available = parseInt($scope.room.is_available);

        // $scope.room.images = $scope.room.images.map((f) => f.id);
        console.log($scope.room.images);
        $scope.room.facilities = $scope.room.facilities.map((f) => f.id);
        // $scope.room.services = $scope.room.services.map((f) => f.id);


    }


    $scope.createRoom = function() {

        $scope.roomForm.$setPristine();
        $scope.roomForm.$setUntouched();
        for (let i = 0; i < $scope.services.length; i++) {
            $scope.servicetemp[$scope.services[i].id] = {
                id: $scope.services[i].id,
                status: false,
                // count: 1
            };
        }

        $scope.room = {
            is_available: 1,
            facilities: [],
            services: [],
            images: []
        };
        // if (!$scope.is_admin) {
        //     $scope.room.hotel_id = $scope.user.hotel_id;
        // }
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRoom').show('slow');
        $('#searchRoom').hide();
        $scope.roomcategories = {};
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }
    $scope.addRoomImage = function() {
        // $scope.room.image = [];
        // $('.custom-file-input').click();
        console.log($scope.room.images);
        // $scope.room.images.push(null);
    }
    $scope.hideCountBboxModal = function() {
        $("#countBboxModal").modal('hide');
    }
    $scope.saveRoom = function() {
        $scope.roomForm.$submitted = true;
        if (!$scope.roomForm.$valid) {
            window.scrollTop();
            return;
        }
        $scope.count = 1;
        if ($scope.formType == "save") {
            $scope.room_category = $scope.roomcategories.filter((rc) => rc.id == $scope.room.room_category_id);
            $scope.roomcategoryname = $scope.room_category[0].RoomCategory;
            $("#countBboxModal").modal('show');
        } else {
            $scope.addRooms();
        }
    }


    $scope.getRoomBookings = function(room_id) {

        $scope.ajaxGet('getRoomBookings', { room_id: room_id }, true)
            .then(function(response) {
                // console.log(response.rooms);
                $scope.booking_count = response.booking_count;

            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.addRooms = function() {
        // console.log($scope.room, $scope.count);
        let formUrl = $scope.formType == "save" ? 'nrooms' : 'nrooms/' + $scope.room.id;
        if ($scope.formType != "save") {
            $scope.getRoomBookings($scope.room.id);
            setTimeout(() => {
                if ($scope.booking_count > 0) {
                    bootbox.alert($scope.booking_count + ' no of bookings already exist');
                    return;
                }
            }, 1000);
        }
        $scope.ajaxPost(formUrl, {
                room: $scope.room,
                services: $scope.servicetemp,
                count: $scope.count
            }, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.rooms.push(response.room);
                    $scope.rooms.push(response.services);
                    $("#countBboxModal").modal('hide');
                } else {
                    $scope.rooms = $scope.rooms.map((room) => room.id == $scope.room.id ? $scope.room : room)
                }
                $scope.getnRooms();
                $('#addNewRoom').hide('slow');

                $scope.room = {};
            })
            .catch(function(e) {
                console.log(response);
            });
        // return

    }

    $scope.deleteRoom = function(c) {
        $scope.room = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.room_title + "'?",
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
                    $scope.ajaxPost('nrooms/del', { id: $scope.room.id }, false)
                        .then(function(response) {
                            $scope.rooms = $scope.rooms.filter((room) => room.id != response.id);
                            window.scrollTop();
                            $('#addNewRoom').hide('slow');
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
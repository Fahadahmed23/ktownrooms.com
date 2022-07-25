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
    $scope.order_by_column = 'hotel_id'
    $scope.servicetemp = [];
    $scope.temp_room_categories = [];

    // datatables
    // $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
    //     .withDOM("<'row  m-0'<'col-sm-12'tr>>" +
    //         "<'row p-2  m-0'<'col-sm-5'i><'col-sm-7'p>>")
    //     .withOption('stateSave', true);
    // $scope.dtColumnDefs = [
    //     DTColumnDefBuilder.newColumnDef([2]).notSortable()
    // ];

    $scope.init = function() {
        $scope.getnRooms(1);
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

        // if ($scope.roomcategories.length < 1) {
        //     $scope.roomcategories = angular.copy($scope.temp_room_categories);
        // }



    }



    $scope.pagination = {
        current: 1
    };
    $scope.room_per_page = 10
    $scope.total_room = 100
    $scope.filter;
    $scope.order_by;
    $scope.filter_rooms = function(filters) {
        $scope.pagination = {
            current: 1
        };
        $scope.filter = filters
        $scope.order_by_column= 'hotel_id'
        $scope.order_by = ''
        $scope.getnRooms(1)
    }
    $scope.getnRooms = function (page_no) {
        let room_fetch_url = 'fetchrooms?'
        if (page_no) {
            room_fetch_url += 'PageNo=' + page_no
        }
        if ($scope.room_per_page) {
            room_fetch_url += '&results_per_page=' + $scope.room_per_page
        }
        if ($scope.filter !== undefined) {
            if ($scope.filter.room_title) {
                room_fetch_url += '&RoomTitle=' + $scope.filter.room_title
            }
            if ($scope.filter.room_category_id) {
                room_fetch_url += '&RoomCategory=' + $scope.filter.room_category_id
            }
            if ($scope.filter.hotel) {
                room_fetch_url += '&HotelName=' + $scope.filter.hotel
            }
            if ($scope.filter.room_type_id) {
                room_fetch_url += '&RoomType=' + $scope.filter.room_type_id
            }
        }
        room_fetch_url += '&OrderBy=' + $scope.order_by_column

        $scope.ajaxGet(room_fetch_url, {}, true)
            .then(function (response) {
                $scope.rooms = response.result;
                $scope.total_room = response.count;
                $scope.user = response.user;
                $scope.is_admin = response.is_admin;

                $scope.roomtypes = [
                    {
                        "id": 18,
                        "RoomType": "Budget",
                        "deleted_at": null,
                        "created_at": "2021-04-06 06:31:50",
                        "CreationIP": "110.93.214.234",
                        "created_by": "1",
                        "CreatedByModule": "Type Management",
                        "updated_at": "2021-04-06 06:31:50",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null
                    },
                    {
                        "id": 20,
                        "RoomType": "Deluxe Room",
                        "deleted_at": null,
                        "created_at": "2021-09-20 10:27:57",
                        "CreationIP": "205.164.158.97",
                        "created_by": "1",
                        "CreatedByModule": "Type Management",
                        "updated_at": "2021-09-20 10:27:57",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null
                    },
                    {
                        "id": 21,
                        "RoomType": "Family Hall",
                        "deleted_at": null,
                        "created_at": "2021-09-20 10:28:03",
                        "CreationIP": "205.164.158.97",
                        "created_by": "1",
                        "CreatedByModule": "Type Management",
                        "updated_at": "2021-09-20 10:28:03",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null
                    },
                    {
                        "id": 17,
                        "RoomType": "Premium",
                        "deleted_at": null,
                        "created_at": "2021-04-06 06:12:39",
                        "CreationIP": "110.93.214.234",
                        "created_by": "1",
                        "CreatedByModule": "Type Management",
                        "updated_at": "2021-04-06 06:12:39",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null
                    },
                    {
                        "id": 19,
                        "RoomType": "Quad Room",
                        "deleted_at": null,
                        "created_at": "2021-05-27 14:03:32",
                        "CreationIP": "122.254.74.153",
                        "created_by": "1",
                        "CreatedByModule": "Type Management",
                        "updated_at": "2021-06-09 15:06:30",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null
                    }
                ];
                $scope.roomcategories = [
                    {
                        "id": 34,
                        "RoomCategory": "Budget Double Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#00ccff",
                        "deleted_at": null,
                        "created_at": "2021-04-06 06:16:31",
                        "CreationIP": "110.93.214.234",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-20 10:32:45",
                        "UpdationIP": "205.164.158.97",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "34",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 41,
                        "RoomCategory": "Deluxe",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "6",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-08-04 19:03:28",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-08-04 19:03:28",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "41",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 35,
                        "RoomCategory": "Deluxe Double Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-04-06 06:16:46",
                        "CreationIP": "110.93.214.234",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-08 22:34:07",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "35",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 48,
                        "RoomCategory": "Deluxe Room",
                        "AllowedOccupants": "3",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#56cbcd",
                        "deleted_at": null,
                        "created_at": "2021-09-23 19:26:29",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-23 19:26:29",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "48",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 42,
                        "RoomCategory": "Family Hall",
                        "AllowedOccupants": "10",
                        "MaxAllowedOccupants": "15",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#e90101",
                        "deleted_at": null,
                        "created_at": "2021-09-20 10:30:54",
                        "CreationIP": "205.164.158.97",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-20 10:30:54",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "42",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 47,
                        "RoomCategory": "Master Room",
                        "AllowedOccupants": "3",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#f2b1da",
                        "deleted_at": null,
                        "created_at": "2021-09-23 19:25:12",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-23 19:25:12",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "47",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 40,
                        "RoomCategory": "Premium Double Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-06-09 15:59:08",
                        "CreationIP": "122.254.74.153",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-08 22:34:49",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "40",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 38,
                        "RoomCategory": "Premium Tripple Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-05-20 12:22:33",
                        "CreationIP": "59.103.194.27",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-08 22:34:34",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "38",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 39,
                        "RoomCategory": "Premium Twin Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-06-09 15:39:56",
                        "CreationIP": "122.254.74.153",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-08 22:34:41",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "39",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 36,
                        "RoomCategory": "Quad Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-04-06 06:17:01",
                        "CreationIP": "110.93.214.234",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-08 22:34:15",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "36",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 46,
                        "RoomCategory": "Single Room",
                        "AllowedOccupants": "1",
                        "MaxAllowedOccupants": "3",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#03594f",
                        "deleted_at": null,
                        "created_at": "2021-09-21 23:03:02",
                        "CreationIP": "205.164.156.194",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-21 23:03:58",
                        "UpdationIP": "205.164.156.194",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "46",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 49,
                        "RoomCategory": "Standard Room",
                        "AllowedOccupants": "3",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#ffd500",
                        "deleted_at": null,
                        "created_at": "2021-09-23 19:27:04",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-23 19:27:04",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "49",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 43,
                        "RoomCategory": "Triple",
                        "AllowedOccupants": "1",
                        "MaxAllowedOccupants": "10",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-09-21 20:10:13",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-27 12:57:54",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "43",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 45,
                        "RoomCategory": "Triple Room",
                        "AllowedOccupants": "3",
                        "MaxAllowedOccupants": "8",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": "#cc0f0f",
                        "deleted_at": null,
                        "created_at": "2021-09-21 20:21:55",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-21 20:26:54",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "45",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 44,
                        "RoomCategory": "Tripple",
                        "AllowedOccupants": "3",
                        "MaxAllowedOccupants": "8",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-09-21 20:19:13",
                        "CreationIP": "72.255.9.46",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-21 20:19:13",
                        "UpdationIP": null,
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "44",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    },
                    {
                        "id": 37,
                        "RoomCategory": "Twin Room",
                        "AllowedOccupants": "2",
                        "MaxAllowedOccupants": "5",
                        "AdditionalGuestCharges": "500.00",
                        "Border": null,
                        "Color": null,
                        "deleted_at": null,
                        "created_at": "2021-05-06 09:44:45",
                        "CreationIP": "182.190.17.117",
                        "created_by": "1",
                        "CreatedByModule": "model",
                        "updated_at": "2021-09-08 22:34:23",
                        "UpdationIP": "72.255.9.46",
                        "updated_by": null,
                        "UpdatedByModule": null,
                        "facilities": [
                            {
                                "id": 29,
                                "Facility": "Free WiFi",
                                "Image": "http://partners.ktownrooms.com/images/1623430371.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-04-06 06:01:05",
                                "CreationIP": "110.93.214.234",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 09:52:53",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "29"
                                }
                            },
                            {
                                "id": 30,
                                "Facility": "Free Parking",
                                "Image": "http://partners.ktownrooms.com/images/1623435045.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:05",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:10:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "30"
                                }
                            },
                            {
                                "id": 31,
                                "Facility": "Smoking Room",
                                "Image": "http://partners.ktownrooms.com/images/1623432506.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:26",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:28:27",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "31"
                                }
                            },
                            {
                                "id": 32,
                                "Facility": "Non Smoking",
                                "Image": "http://partners.ktownrooms.com/images/1623439062.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-05-26 10:11:55",
                                "CreationIP": "59.103.205.209",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:17:44",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "32"
                                }
                            },
                            {
                                "id": 41,
                                "Facility": "Room Service",
                                "Image": "http://partners.ktownrooms.com/images/1623432717.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 06:00:05",
                                "CreationIP": "72.255.9.46",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:31:58",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "41"
                                }
                            },
                            {
                                "id": 42,
                                "Facility": "AC",
                                "Image": "http://partners.ktownrooms.com/images/1623336466.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:26:47",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-11 07:47:48",
                                "UpdationIP": "110.93.214.234",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "42"
                                }
                            },
                            {
                                "id": 43,
                                "Facility": "LED TV",
                                "Image": "http://partners.ktownrooms.com/images/1623438403.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:29:32",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:06:46",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "43"
                                }
                            },
                            {
                                "id": 44,
                                "Facility": "Key Access",
                                "Image": "http://partners.ktownrooms.com/images/1623435063.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:32:19",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 11:11:04",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "44"
                                }
                            },
                            {
                                "id": 45,
                                "Facility": "Kitchen utensil",
                                "Image": "http://partners.ktownrooms.com/images/1623432799.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:33:24",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:33:22",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "45"
                                }
                            },
                            {
                                "id": 46,
                                "Facility": "Luggage Storage",
                                "Image": "http://partners.ktownrooms.com/images/1623432912.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:34:29",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:35:13",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "46"
                                }
                            },
                            {
                                "id": 47,
                                "Facility": "Toletires",
                                "Image": "http://partners.ktownrooms.com/images/1623439080.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:38:31",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:18:02",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "47"
                                }
                            },
                            {
                                "id": 49,
                                "Facility": "Housekeeping",
                                "Image": "http://partners.ktownrooms.com/images/1623432213.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:39:55",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:34",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "49"
                                }
                            },
                            {
                                "id": 50,
                                "Facility": "Accessibility",
                                "Image": "http://partners.ktownrooms.com/images/1623432182.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:11",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 10:23:03",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "50"
                                }
                            },
                            {
                                "id": 51,
                                "Facility": "Intercom",
                                "Image": "http://partners.ktownrooms.com/images/1623439194.png",
                                "size": null,
                                "type": null,
                                "IsActive": null,
                                "deleted_at": null,
                                "created_at": "2021-06-09 14:45:30",
                                "CreationIP": "122.254.74.153",
                                "created_by": "1",
                                "CreatedByModule": "model",
                                "updated_at": "2021-06-12 12:19:55",
                                "UpdationIP": "72.255.9.46",
                                "updated_by": null,
                                "UpdatedByModule": null,
                                "pivot": {
                                    "room_category_id": "37",
                                    "facility_id": "51"
                                }
                            }
                        ]
                    }
                ];
                $scope.facilities = response.facilities;

            })
            .catch(function (e) {
                console.log(e);
            })
    }
    $scope.sorting = function (order_by) {

        var order_by_column_final
        if ($scope.order_by === '-') {
            $scope.order_by = ''
            order_by_column_final = order_by + 'Minus'
        } else {
            $scope.order_by = '-'
            order_by_column_final = order_by

        }
        $scope.order_by_column = order_by_column_final
        $scope.getnRooms(1)
    }

    $scope.editRoom = function (c) {
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

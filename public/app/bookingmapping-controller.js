app.controller('bookingmappingCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.mappings = [];
    $scope.mappings = {};

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
        $scope.getBookingMappings();
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
        $("#mappingFormSec").show('slow');
    }
    $scope.hideCreate = function() {
        $("#mappingFormSec").hide('slow');
    }

    $scope.saveBookingMapping = function() {
        $scope.myForm.$submitted = true;

        if (!$scope.myForm.$valid) {
            return;
        }

        if ($scope.mapping.type == ' ') {
            return toastr.error('Type is missing');
        }

        if ($scope.mapping.client == ' ') {
            return toastr.error('Client is missing');
        }

        console.log('save');
        let formUrl = $scope.formType == "save" ? 'booking_mappings' : 'booking_mappings/' + $scope.mapping.id;

        $scope.ajaxPost(formUrl, $scope.mapping, true)
            .then(function(response) {
                if ($scope.formType == "save") {
                    if (response.success == true) {
                        $scope.myForm.$setPristine();
                        $scope.myForm.$setUntouched();
                        $scope.mappings.push(response.mapping);
                        $scope.mapping = {};
                        $("#mappingFormSec").hide('slow');
                    }
                } else {
                    if (response.success == true) {
                        $scope.myForm.$setPristine();
                        $scope.myForm.$setUntouched();
                        $scope.mappings = $scope.mappings.map((mapping) => mapping.id == response.mapping.id ? response.mapping : mapping);
                        $scope.mapping = {};
                        $("#mappingFormSec").hide('slow');
                    }
                }


            })
            .catch(function(e) {
                toastr.error(e);
            });
    }


    $scope.editMapping = function(p) {
        window.scrollTop();
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();
        $scope.mapping = angular.copy(p);
        $scope.formType = "update";
        $('#mappingFormSec').show('slow');
        // $('#des-div').css('display', 'block');
        $scope.getDestination();


        console.log($scope.mapping);
    }


    $scope.getBookingMappings = function(searchFields = {}) {
        $scope.ajaxPost('getBookingMappings', searchFields, true)
            .then(function(response) {
                $scope.mappings = response.mappings;
            })
            .catch(function(e) {
                // console.log(e);
            })
    }

    $scope.searchFilter = function(searchFields) {
        $scope.getBookingMappings(searchFields);
    }

    $scope.getDestination = function() {
            if ($scope.mapping.type == 'hotel') {

                $scope.getHotels();
                $scope.mapping.source_type = 'int';

                $('#des-div').css('display', 'block');
            } else if ($scope.mapping.type == 'roomcategory') {
                $scope.getRoomCategories();
                $scope.mapping.source_type = 'str';

                $('#des-div').css('display', 'block');

            } else {
                $scope.destinations = [];
                $('#des-div').css('display', 'none');
            }
            console.log($scope.mapping);
        }
        // 
    $scope.getRoomCategories = function() {
        // var data = [];
        $scope.ajaxGet('getRoomCategories', {}, true)
            .then(function(response) {
                var obj1 = [];
                var obj = {};
                response.forEach(element => {
                    obj = {
                        id: element.id,
                        name: element.RoomCategory
                    };
                    obj1.push(obj);
                });
                $scope.destinations = obj1;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.getHotels = function() {
        // var data = [];
        $scope.ajaxGet('getCurrentHotels', {}, true)
            .then(function(response) {
                var obj1 = [];
                var obj = {};
                response.hotels.forEach(element => {
                    obj = {
                        id: element.id,
                        name: element.HotelName
                    };
                    obj1.push(obj);
                });

                $scope.destinations = obj1;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.revert = function() {
        $('#addNewInventory').hide('slow');
    }
});



// comment kt-new 
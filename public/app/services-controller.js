app.controller('servicesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.services = [];
    $scope.service = {};
    $scope.departments = {};
    $scope.servicetypes = {};
    $scope.inventories = {}
    $scope.formType = "";

    $scope.searchName = "";
    $scope.searchDeparment = "";
    $scope.searchType = "";

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
        $scope.getServices();

        $('.pickatime-startTime,.pickatime-endTime').pickatime({});
    }


    // $scope.getIcons = function() {
    //     $scope.ajaxGet('getIcons', {}, true)
    //         .then(function(response) {
    //             $scope.fontawsomeicons = response;
    //             console.log($scope.fontawsomeicons);
    //         })
    //         .catch(function(e) {
    //             console.log(e);
    //         })
    // }
    $scope.clearPicture = function(s) {
        document.getElementById('fileLabel').innerHTML = "";
        if (s == "service") {
            $scope.service.IconPath = null;
        } else {
            $scope.service.IconPath = null;
        }
    }
    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.filterData = function(searchFields, check) {
        if (check == 'clear') {
            $scope.filters = {};
        } else {
            $scope.filters = angular.copy(searchFields);
        }
        $scope.getServices($scope.filters);
    }
    $scope.getServices = function() {
        $scope.ajaxPost('getServices', {
                filters: $scope.filters,
            }, true)
            .then(function(response) {

                $scope.user = response.user;
                $scope.is_admin = response.is_admin;

                $scope.services = response.services;
                $scope.departments = response.departments;
                $scope.hotels = response.hotels;
                $scope.servicetypes = response.servicetypes;
                $scope.inventories = response.inventories;
                console.log($scope.services);
            })

        .catch(function(e) {
            console.log(e);
        })
    }


    $scope.editService = function(c) {
        $scope.service = angular.copy(c);
        console.log(c);
        $scope.formType = "update";
        window.scrollTop();
        $('#addNewService').show('slow');
        $('#searchService').hide();
        if ($scope.service.is_24hrs == '1') {
            $scope.service.service_start_time = "";
            $scope.service.service_end_time = "";
        } else {
            $scope.service.service_start_time = moment($scope.service.service_start_time, ["HH:mm:ss"]).format('h:mm A');
            $scope.service.service_end_time = moment($scope.service.service_end_time, ["HH:mm:ss"]).format('h:mm A');
        }
    }

    $scope.createService = function() {
        $scope.myForm.$setUntouched();
        $scope.myForm.$setPristine();
        $scope.service = {};

        // if (!$scope.is_admin) {
        //     $scope.service.hotel_id = $scope.user.hotel_id;
        // }
        $scope.service.is_24hrs = '1';
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewService').show('slow');
        $('#searchService').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveService = function() {
        $scope.myForm.$submitted = true;
        if (!$scope.myForm.$valid) {
            window.scrollTop();
            return;
        }
        if (!$scope.service.IconPath) {
            toastr.error("Please upload service icon");
            return;
        }

        // console.log($scope.service.service_start_time);
        // $scope.service.service_start_time = moment(moment(new Date()).format('YYYY-MM-DD') + ' ' + $scope.service.service_start_time).format('HH:mm:ss');
        // $scope.service.service_end_time = moment(moment(new Date()).format('YYYY-MM-DD') + ' ' + $scope.service.service_end_time).format('HH:mm:ss');

        // $scope.service.service_start_time = moment($scope.service.service_start_time).format("hh:mm:ss");
        // $scope.service.service_end_time = moment($scope.service.service_end_time).format("hh:mm:ss");


        let formUrl = $scope.formType == "save" ? 'services' : 'services/' + $scope.service.id;
        $scope.ajaxPost(formUrl, $scope.service, false)
            .then(function(response) {
                if (response.success) {
                    if ($scope.formType == "save") {
                        $scope.services.push(response.service);
                    } else {
                        $scope.services = $scope.services.map((service) => service.id == $scope.service.id ? $scope.service : service)
                    }
                    $('#addNewService').hide('slow');
                    $scope.service = {};
                    $scope.getServices();
                }

            })
            .catch(function(e) {
                console.log(response);
            });
    }

    $scope.deleteService = function(c) {
        $scope.service = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.Service + "'?",
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
                    $scope.ajaxPost('services/del', { id: $scope.service.id, Service: $scope.service.Service }, false)
                        .then(function(response) {
                            $scope.services = $scope.services.filter((service) => service.id != response.id);
                            window.scrollTop();
                            $('#addNewService').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewService').hide('slow');
    }
});
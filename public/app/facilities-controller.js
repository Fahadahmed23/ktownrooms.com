app.controller('facilitiesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.facilities = [];
    $scope.facility = {};
    $scope.formType = "";
    $scope.errors = [];
    $scope.fontawsomeicons = {};
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
        $scope.getFacilities();
        $scope.getIcons();
    }
    $scope.getIcons = function() {
        $scope.ajaxGet('getIcons', {}, true)
            .then(function(response) {
                $scope.fontawsomeicons = response;
            })
            .catch(function(e) {
                console.log(e);
            })
            // setTimeout(function() { console.log($scope.fontawsomeicons); }, 3000);
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.clearPicture = function(r) {
        document.getElementById('fileLabel').innerHTML = "";
        if (r == "facility") {
            $scope.facility.Image = null;
        } else {
            $scope.facility.Image = null;
        }
    }

    $scope.getFacilities = function() {
        $scope.ajaxGet('getFacilities', {}, true)
            .then(function(response) {
                $scope.facilities = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.editFacility = function(c) {

        $scope.facilityForm.$setPristine();
        $scope.facilityForm.$setUntouched();

        $scope.facility = angular.copy(c);
        console.log($scope.facility);
        $scope.formType = "update";
        $('#addNewFacility').show('slow');
        $('#searchFacility').hide();
    }

    $scope.createFacility = function() {
        $scope.facilityForm.$setPristine();
        $scope.facilityForm.$setUntouched();

        $scope.facility = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewFacility').show('slow');
        $('#searchFacility').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveFacility = function() {
        // let f = $('#facilityForm');
        // if (!f.valid()) {
        //     return;
        // }

        $scope.facilityForm.$submitted = true;
        if (!$scope.facilityForm.$valid) {
            return;
        }
        if (!$scope.facility.Image) {
            toastr.error("Please upload facility icon");
            return;
        }

        let formUrl = $scope.formType == "save" ? 'facilities' : 'facilities/' + $scope.facility.id;
        $scope.ajaxPost(formUrl, $scope.facility, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.facilities.push(response.facility);
                } else {
                    $scope.facilities = $scope.facilities.map((facility) => facility.id == $scope.facility.id ? $scope.facility : facility)
                }
                $scope.facility = {};
                $scope.getFacilities();
                $('#addNewFacility').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deleteFacility = function(c) {
            $scope.facility = angular.copy(c);
            console.log($scope.facility);
            bootbox.confirm({
                title: 'Confirm Deletion',
                message: "Are you sure you want to delete '" + c.Facility + "'?",
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
                        $scope.ajaxPost('facilities/del', { id: $scope.facility.id }, false)
                            .then(function(response) {
                                $scope.facilities = $scope.facilities.filter((facility) => facility.id != response.id);
                            })
                            .catch(function(e) {
                                toastr.error(e);
                            })
                    }
                }
            });
        }
        // $scope.showIcons = function() {
        //     $("#iconModal").modal();
        // }

    $scope.revert = function() {
        $('#addNewFacility').hide('slow');
    }
});
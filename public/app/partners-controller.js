app.controller('partnersCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.partners = [];
    $scope.partner = {};
    $scope.formType = "";
    $scope.errors = [];
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
        $scope.getPartners();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getPartners = function() {
        $scope.ajaxGet('getPartners', {}, true)
            .then(function(response) {
                $scope.partners = response.partners;
                console.log($scope.partners);

                // for dropdown
                $scope.hotels = response.hotels;
                console.log($scope.hotels);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createPartner = function() {
        window.scrollTop();
        $scope.partnerForm.$setPristine();
        $scope.partnerForm.$setUntouched();
        $scope.partner = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewPartner').show('slow');
    }


    $scope.editPartner = function(p) {
        window.scrollTop();
        $scope.partnerForm.$setPristine();
        $scope.partnerForm.$setUntouched();
        $scope.partner = angular.copy(p);
        $scope.formType = "update";
        $('#addNewPartner').show('slow');

        console.log($scope.partner);
    }


    $scope.savePartner = function() {
        $scope.partnerForm.$submitted = true;
        if (!$scope.partnerForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'partners' : 'partners/' + $scope.partner.id;
        $scope.ajaxPost(formUrl, $scope.partner, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.partners.push(response.partner);
                } else {
                    $scope.partners = $scope.partners.map((partner) => partner.id == $scope.partner.id ? $scope.partner : partner)
                }
                $scope.partner = {};
                $scope.getPartners();
                $('#addNewPartner').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });

    }

    $scope.deletePartner = function(p) {
        $scope.partner = angular.copy(p);
        console.log($scope.partner);
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
                    $scope.ajaxPost('partners/del', { id: $scope.partner.id }, false)
                        .then(function(response) {
                            $scope.partners = $scope.partners.filter((partner) => partner.id != response.id);
                            window.scrollTop();
                            $('#addNewPartner').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewPartner').hide('slow');
    }
});
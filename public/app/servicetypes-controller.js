app.controller('servicetypesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.servicetypes = [];

    $scope.servicetype={};

    $scope.formType = "";

    $scope.filterSearchText = "";

    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
    .withDOM("<'row'<'col-sm-12'tr>>"+
    "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
    .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {

        $scope.getServiceTypes();
    }

    $scope.getServiceTypes = function() {
        $scope.ajaxGet('getServiceTypes', {
            }, true)
            .then(function(response) {
                $scope.servicetypes = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editServiceType = function (c){
        $scope.servicetype=angular.copy(c);
        $scope.formType = "update";

        $('#addNewServiceType').show('slow');
        $('#searchServiceType').hide();
    }


    $scope.createServiceType = function () {
        $scope.servicetype = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewServiceType').show('slow');
        $('#searchServiceType').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveServiceType = function() {
        let formUrl = $scope.formType == "save" ? 'servicetypes' : 'servicetypes/' + $scope.servicetype.id;
        
        $scope.ajaxPost(formUrl, $scope.servicetype, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.servicetypes.push(response.servicetype);
                } else {
                    $scope.servicetypes = $scope.servicetypes.map((servicetype) => servicetype.id == $scope.servicetype.id ? $scope.servicetype : servicetype)
                }
                
                $scope.servicetype = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteServiceType = function(c) {
        $scope.servicetype = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.ServiceType + "'?",
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
                    $scope.ajaxPost('servicetypes/del', {id: $scope.servicetype.id}, false)
                    .then(function(response) {
                        $scope.servicetypes = $scope.servicetypes.filter((servicetype)=>servicetype.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewServiceType').hide('slow');
    }
});
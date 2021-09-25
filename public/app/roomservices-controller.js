app.controller('roomservicesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.roomservices = [];

    $scope.roomservice={};

    $scope.formType = "";

    $scope.filterSearchText = "";

    //$scope.errors = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
    .withDOM("<'row'<'col-sm-12'tr>>"+
    "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
    .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {

        $scope.getRoomServices();
    }

    $scope.getRoomServices = function() {
        $scope.ajaxGet('getRoomServices', {
            }, true)
            .then(function(response) {
                $scope.roomservices = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editRoomService = function (c){
        $scope.roomservice=angular.copy(c);
        $scope.formType = "update";

        $('#addNewRoomService').show('slow');
        $('#searchRoomService').hide();
    }


    $scope.createRoomService = function () {
        $scope.roomservice = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRoomService').show('slow');
        $('#searchRoomService').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveRoomService = function() {
        let formUrl = $scope.formType == "save" ? 'roomservices' : 'roomservices/' + $scope.roomservice.id;
        
        $scope.ajaxPost(formUrl, $scope.roomservice, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.roomservices.push(response.roomservice);
                } else {
                    $scope.roomservices = $scope.roomservices.map((roomservice) => roomservice.id == $scope.roomservice.id ? $scope.roomservice : roomservice)
                }
                
                $scope.roomservice = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteRoomService = function(c) {
        $scope.roomservice = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.RoomServiceName + "'?",
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
                    $scope.ajaxPost('roomservices/del', {id: $scope.roomservice.id}, false)
                    .then(function(response) {
                        $scope.roomservices = $scope.roomservices.filter((roomservice)=>roomservice.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewRoomService').hide('slow');
    }
});
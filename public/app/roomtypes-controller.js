app.controller('roomtypesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.roomtypes = [];

    $scope.roomtype={};

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

        $scope.getRoomTypes();
    }

    $scope.getRoomTypes = function() {
        $scope.ajaxGet('getRoomTypes', {
            }, true)
            .then(function(response) {
                $scope.roomtypes = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editRoomType = function (c){
        $scope.roomtype=angular.copy(c);
        $scope.formType = "update";

        $('#addNewRoomType').show('slow');
        $('#searchRoomType').hide();
    }


    $scope.createRoomType = function () {
        $scope.roomtype = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRoomType').show('slow');
        $('#searchRoomType').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveRoomType = function() {
        let formUrl = $scope.formType == "save" ? 'roomtypes' : 'roomtypes/' + $scope.roomtype.id;
        
        $scope.ajaxPost(formUrl, $scope.roomtype, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.roomtypes.push(response.roomtype);
                } else {
                    $scope.roomtypes = $scope.roomtypes.map((roomtype) => roomtype.id == $scope.roomtype.id ? $scope.roomtype : roomtype)
                }
                
                $scope.roomtype = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteRoomType = function(c) {
        $scope.roomtype = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.RoomType + "'?",
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
                    $scope.ajaxPost('roomtypes/del', {id: $scope.roomtype.id}, false)
                    .then(function(response) {
                        $scope.roomtypes = $scope.roomtypes.filter((roomtype)=>roomtype.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewRoomType').hide('slow');
    }
});
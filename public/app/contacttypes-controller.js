app.controller('contacttypesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.contacttypes = [];

    $scope.contacttype={};

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

        $scope.getContactTypes();
    }

    $scope.getContactTypes = function() {
        $scope.ajaxGet('getContactTypes', {
            }, true)
            .then(function(response) {
                $scope.contacttypes = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editContactType = function (c){
        $scope.contacttype=angular.copy(c);
        $scope.formType = "update";

        $('#addNewContactType').show('slow');
        $('#searchContactType').hide();
    }


    $scope.createContactType = function () {
        $scope.contacttype = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewContactType').show('slow');
        $('#searchContactType').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveContactType = function() {
        let formUrl = $scope.formType == "save" ? 'contacttypes' : 'contacttypes/' + $scope.contacttype.id;
        
        $scope.ajaxPost(formUrl, $scope.contacttype, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.contacttypes.push(response.contacttype);
                } else {
                    $scope.contacttypes = $scope.contacttypes.map((contacttype) => contacttype.id == $scope.contacttype.id ? $scope.contacttype : contacttype)
                }
                
                $scope.contacttype = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteContactType = function(c) {
        $scope.contacttype = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.ContactTypeName + "'?",
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
                    $scope.ajaxPost('contacttypes/del', {id: $scope.contacttype.id}, false)
                    .then(function(response) {
                        $scope.contacttypes = $scope.contacttypes.filter((contacttype)=>contacttype.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewContactType').hide('slow');
    }
});
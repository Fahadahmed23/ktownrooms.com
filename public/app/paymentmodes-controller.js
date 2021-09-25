app.controller('paymentmodesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.paymentmodes = [];

    $scope.paymentmode={};

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

        $scope.getPaymentModes();
    }

    $scope.getPaymentModes = function() {
        $scope.ajaxGet('getPaymentModes', {
            }, true)
            .then(function(response) {
                $scope.paymentmodes = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editPaymentMode = function (c){
        $scope.paymentmode=angular.copy(c);
        $scope.formType = "update";

        $('#addNewPaymentMode').show('slow');
        $('#searchPaymentMode').hide();
    }


    $scope.createPaymentMode = function () {
        $scope.paymentmode = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewPaymentMode').show('slow');
        $('#searchPaymentMode').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.savePaymentMode = function() {
        let formUrl = $scope.formType == "save" ? 'paymentmodes' : 'paymentmodes/' + $scope.paymentmode.id;
        
        $scope.ajaxPost(formUrl, $scope.paymentmode, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.paymentmodes.push(response.paymentmode);
                } else {
                    $scope.paymentmodes = $scope.paymentmodes.map((paymentmode) => paymentmode.id == $scope.paymentmode.id ? $scope.paymentmode : paymentmode)
                }
                
                $scope.paymentmode = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deletePaymentMode = function(c) {
        $scope.paymentmode = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.PaymentMode + "'?",
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
                    $scope.ajaxPost('paymentmodes/del', {id: $scope.paymentmode.id}, false)
                    .then(function(response) {
                        $scope.paymentmodes = $scope.paymentmodes.filter((paymentmode)=>paymentmode.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewPaymentMode').hide('slow');
    }
});
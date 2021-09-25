app.controller('taxratesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.taxrates = [];

    $scope.taxrate={};

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

        $scope.getTaxRates();
    }

    $scope.getTaxRates = function() {
        
        $scope.ajaxGet('getTaxRates', {
            }, true)
            .then(function(response) {
                $scope.taxrates = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editTaxRate = function (c){
        $scope.taxrate=angular.copy(c);
        $scope.formType = "update";

        $('#addNewTaxRate').show('slow');
        $('#searchTaxRate').hide();
    }


    $scope.createTaxRate = function () {
        $scope.taxrate = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewTaxRate').show('slow');
        $('#searchTaxRate').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveTaxRate = function() {
        let formUrl = $scope.formType == "save" ? 'taxrates' : 'taxrates/' + $scope.taxrate.id;
        
        $scope.ajaxPost(formUrl, $scope.taxrate, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.taxrates.push(response.taxrate);
                } else {
                    $scope.taxrates = $scope.taxrates.map((taxrate) => taxrate.id == $scope.taxrate.id ? $scope.taxrate : taxrate)
                }
                
                $scope.taxrate = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteTaxRate = function(c) {
        $scope.taxrate = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.TaxRateName + "'?",
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
                    $scope.ajaxPost('taxrates/del', {id: $scope.taxrate.id}, false)
                    .then(function(response) {
                        $scope.taxrates = $scope.taxrates.filter((taxrate)=>taxrate.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewTaxRate').hide('slow');
    }
});
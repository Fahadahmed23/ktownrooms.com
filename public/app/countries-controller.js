app.controller('countriesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.countries = [];

    $scope.country={};

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

        $scope.getCountries();
    }

    $scope.getCountries = function() {
        $scope.ajaxGet('getCountries', {
            }, true)
            .then(function(response) {
                $scope.countries = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editCountry = function (c){
        $scope.country=angular.copy(c);
        $scope.formType = "update";

        $('#addNewCountry').show('slow');
        $('#searchCountry').hide();
    }


    $scope.createCountry = function () {
        $scope.country = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewCountry').show('slow');
        $('#searchCountry').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveCountry = function() {
        let formUrl = $scope.formType == "save" ? 'countries' : 'countries/' + $scope.country.id;
        
        $scope.ajaxPost(formUrl, $scope.country, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.countries.push(response.country);
                } else {
                    $scope.countries = $scope.countries.map((country) => country.id == $scope.country.id ? $scope.country : country)
                }
                
                $scope.country = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteCountry = function(c) {
        $scope.country = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.CountryName + "'?",
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
                    $scope.ajaxPost('countries/del', {id: $scope.country.id}, false)
                    .then(function(response) {
                        $scope.countries = $scope.countries.filter((country)=>country.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewCountry').hide('slow');
    }
});
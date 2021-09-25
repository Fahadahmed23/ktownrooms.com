app.controller('citiesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.cities = [];

    $scope.city={};

    $scope.states = [];

    $scope.state={};

    $scope.country={};

    $scope.countries = [];

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

        $scope.getCitiesCity();
        $scope.loadCountry();
        
    }

    $scope.loadCountry = function() {
        $scope.ajaxGet('getCountryList', {
            }, true)
            .then(function(response) {
                $scope.countries = response;               
            })
            .catch(function(e){
                console.log(e);
            })
    }

     $scope.loadState = function() {
        $scope.ajaxGet('getStateList', {country_id: $scope.city.country_id}, true)
            .then(function(response) {
                $scope.states = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }
    
    $scope.getCitiesCity = function() {
        $scope.ajaxGet('getCitiesCity', {
            }, true)
            .then(function(response) {
                $scope.cities = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editCity = function (c){
        $scope.city=angular.copy(c);
        //console.log($scope.city);
        $scope.loadState();
        $scope.formType = "update";

        $('#addNewCity').show('slow');
        $('#searchCity').hide();
    }


    $scope.createCity = function () {
        $scope.city = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewCity').show('slow');
        $('#searchCity').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveCity = function() {
        let formUrl = $scope.formType == "save" ? 'cities' : 'cities/' + $scope.city.id;
        
        $scope.ajaxPost(formUrl, $scope.city, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.cities.push(response.city);
                } else {
                    $scope.cities = $scope.cities.map((city) => city.id == $scope.city.id ? $scope.city : city)
                }
                $scope.getCitiesCity();
                $scope.city = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteCity = function(c) {
        $scope.city = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.CityName + "'?",
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
                    $scope.ajaxPost('cities/del', {id: $scope.city.id}, false)
                    .then(function(response) {
                        $scope.cities = $scope.cities.filter((city)=>city.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewCity').hide('slow');
    }
});
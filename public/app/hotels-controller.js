app.controller('hotelsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.hotels = [];

    $scope.hotel={};

    $scope.companies = [];

    $scope.company={};

    $scope.cities = [];

    $scope.city={};

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

        $scope.getHotels();
        $scope.getCompanies();
        $scope.getCities();
    }

    $scope.getHotels = function() {
        $scope.ajaxGet('getHotels', {
            }, true)
            .then(function(response) {
                $scope.hotels = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }
    $scope.getCompanies = function() {
        $scope.ajaxGet('getCompanies', {
            }, true)
            .then(function(response) {
                $scope.companies = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.getCities = function() {
        $scope.ajaxGet('getCities', {
            }, true)
            .then(function(response) {
                $scope.cities = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editHotel = function (c){
        $scope.hotel=angular.copy(c);
        $scope.formType = "update";

        $('#addNewHotel').show('slow');
        $('#searchHotel').hide();
    }


    $scope.createHotel = function () {
        $scope.hotel = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewHotel').show('slow');
        $('#searchHotel').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveHotel = function() {
        let formUrl = $scope.formType == "save" ? 'hotels' : 'hotels/' + $scope.hotel.id;
        
        $scope.ajaxPost(formUrl, $scope.hotel, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.hotels.push(response.hotel);
                } else {
                    $scope.hotels = $scope.hotels.map((hotel) => hotel.id == $scope.hotel.id ? $scope.hotel : hotel)
                }
                
                $scope.hotel = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteHotel = function(c) {
        $scope.hotel = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.HotelName + "'?",
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
                    $scope.ajaxPost('hotels/del', {id: $scope.hotel.id}, false)
                    .then(function(response) {
                        $scope.hotels = $scope.hotels.filter((hotel)=>hotel.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewHotel').hide('slow');
    }
});
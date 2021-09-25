app.controller('hotelcontactsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.hotelcontacts = [];

    $scope.hotelcontact={};
    
    $scope.hotels = [];

    $scope.hotel={};

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

        $scope.getHotelContacts();
        $scope.getHotels();
        $scope.getContactTypes();
    }

    $scope.getHotelContacts = function() {
        $scope.ajaxGet('getHotelContacts', {
            }, true)
            .then(function(response) {
                $scope.hotelcontacts = response;
            })
            .catch(function(e){
                console.log(e);
            })
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

    $scope.editHotelContact = function (c){
        $scope.hotelcontact=angular.copy(c);
        $scope.formType = "update";

        $('#addNewHotelContact').show('slow');
        $('#searchHotelContact').hide();
    }


    $scope.createHotelContact = function () {
        $scope.hotelcontact = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewHotelContact').show('slow');
        $('#searchHotelContact').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveHotelContact = function() {
        let formUrl = $scope.formType == "save" ? 'hotelcontacts' : 'hotelcontacts/' + $scope.hotelcontact.id;
        
        $scope.ajaxPost(formUrl, $scope.hotelcontact, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.hotelcontacts.push(response.hotelcontact);
                } else {
                    $scope.hotelcontacts = $scope.hotelcontacts.map((hotelcontact) => hotelcontact.id == $scope.hotelcontact.id ? $scope.hotelcontact : hotelcontact)
                }
                
                $scope.hotelcontact = {};
            })
            .catch(function(e){
                console.log(response);
            });

            $scope.getHotelContacts();
    }

    $scope.deleteHotelContact = function(c) {
        $scope.hotelcontact = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.contact_type_id + "'?",
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
                    $scope.ajaxPost('hotelcontacts/del', {id: $scope.hotelcontact.id}, false)
                    .then(function(response) {
                        $scope.hotelcontacts = $scope.hotelcontacts.filter((hotelcontact)=>hotelcontact.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
        
    }

    $scope.revert = function() {
        $('#addNewHotelContact').hide('slow');
    }
});
app.controller('statesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
  

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

        $scope.getStatesState();
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

    $scope.getStatesState = function() {
        $scope.ajaxGet('getStatesState', {
            }, true)
            .then(function(response) {
                $scope.states = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

   
    $scope.editState = function (c){
        $scope.state=angular.copy(c);
        $scope.formType = "update";

        $('#addNewState').show('slow');
        $('#searchState').hide();
    }


    $scope.createState = function () {
        $scope.state = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewState').show('slow');
        $('#searchState').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveState = function() {
        let formUrl = $scope.formType == "save" ? 'states' : 'states/' + $scope.state.id;
        
        $scope.ajaxPost(formUrl, $scope.state, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.states.push(response.state);
                } else {
                    $scope.states = $scope.states.map((state) => state.id == $scope.state.id ? $scope.state : state)
                }
                
                $scope.state = {};
                $scope.getStatesState();
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteState = function(c) {
        $scope.state = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.StateName + "'?",
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
                    $scope.ajaxPost('states/del', {id: $scope.state.id}, false)
                    .then(function(response) {
                        $scope.states = $scope.states.filter((state)=>state.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewState').hide('slow');
    }
});
app.controller('corporateclientsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.clients = [];
    $scope.client = {};
    $scope.formType = "";
    $scope.errors = [];
    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row m-0 p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {
        $scope.getClients();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getClients = function() {
        $scope.ajaxGet('getClients', {}, true)
            .then(function(response) {
                $scope.clients = response.clients;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createClient = function() {
        window.scrollTop();
        $scope.clientForm.$setPristine();
        $scope.clientForm.$setUntouched();
        $scope.client = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewClient').show('slow');
    }


    $scope.editClient = function(c) {
        window.scrollTop();
        $scope.clientForm.$setPristine();
        $scope.clientForm.$setUntouched();
        $scope.client = angular.copy(c);
        $scope.formType = "update";
        $('#addNewClient').show('slow');

        console.log($scope.client);
    }


    $scope.saveClient = function() {
        $scope.clientForm.$submitted = true;
        if (!$scope.clientForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'clients' : 'clients/' + $scope.client.id;
        $scope.ajaxPost(formUrl, $scope.client, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.clients.push(response.client);
                } else {
                    $scope.clients = $scope.clients.map((client) => client.id == $scope.client.id ? $scope.client : client)
                }
                $scope.client = {};
                $scope.getClients();
                $('#addNewClient').hide('slow');
            })
            .catch(function(e) {
                console.log(response);
            });
    }



    $scope.GetHotels= function()
    {
        // debugger;
     $scope.ajaxGet('getClients', {}, true)
     .then(function(response) {
         debugger;
         $scope.client = response.clients;
         $scope.hotallist = response.hotels;

     })
     .catch(function(e) {
         console.log(e);
     })
    }




    $scope.deleteClient = function(c) {
        $scope.client = angular.copy(c);
        console.log($scope.client);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.FullName + "'?",
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
                    $scope.ajaxPost('clients/del', { id: $scope.client.id }, false)
                        .then(function(response) {
                            $scope.clients = $scope.clients.filter((client) => client.id != response.id);
                            window.scrollTop();
                            $('#addNewClient').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewClient').hide('slow');
    }

    $scope.showImportClientModal = function() {
        $('#clientModal').modal('show');
    }
    $scope.uploadClient = function() {
        // $scope.clientsheet_form.$submitted = true;
        // if (!$scope.clientsheet_form.$valid) {
        //     return;
        // }
        // console.log($scope.co_client_sheet);

    }
    $scope.hideImportClientModal = function() {
        $('#clientModal').modal('hide');
    }

});

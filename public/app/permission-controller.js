app.controller('permissionCtrl', function($scope) {

    $scope.permissionForm = {};

    $scope.createPermission = function() {

        $scope.ajaxPost('addPermission', JSON.parse(angular.toJson($scope.permissionForm))).then(function(response) {
            if (!response.errors) {
                $scope.permissionForm = {};
                $scope.getPermissions();
            }

        })
    }

    $scope.getPermissions = function() {

        $scope.ajaxGet('getPermissions', {}, true)
            .then(function(response) {
                if (response.success) {
                    $scope.permissions = response.payload;
                }

            })
    }

    $scope.showPermissionForm = function(permissionID) {
        $scope.permissionForm = {};
        if (permissionID) {
            $scope.permissionForm = Object.values($scope.permissions).find(permission => permission.id == permissionID);
        }
        setTimeout(function() {
                $('#permission-form-section').show('slow');
            },
            100);

    }

    $scope.hideForm = function(){
        $('#permission-form-section').hide('slow');
    }

    $scope.removePermission = function(permissionID) {
        var find = Object.values($scope.permissions).find(permission => permission.id == permissionID);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete ' + find.name + ' permission!.',
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
                    $scope.ajaxPost('removePermission', { id: permissionID })
                        .then(function(response) {
                            if (!response.errors) {
                                $scope.getPermissions();
                            }

                        })
                }
            }
        });

    }

    // $scope.filterSlots = function(searchFields){
    // 	$scope.ajaxGet('getSlots', searchFields)
    // 		.then(function(response){
    // 			if(response.success){
    // 				$scope.slots = response.payload;
    // 			}

    // 		})

    // }




});
app.controller('usersCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    $scope.users = [];
    $scope.user = {};
    $scope.user_exp = {};
    $scope.roles = [];
    $scope.selectedRoles = [];

    $scope.currentAddress = {};
    $scope.permanentAddress = {};

    $scope.user_address = {};
    $scope.user_addresses = {};
    $scope.cities = [];
    $scope.hotels = [];
    $scope.states = [];
    $scope.departments = [];
    $scope.designations = [];
    $scope.expType = {};
    $scope.refType = {};
    $scope.formType = "save";
    $scope.addressFormType = "save";
    $scope.primary_set = false;

    // filters
    $scope.searchName = "";
    $scope.searchEmail = "";
    $scope.searchPhone = "";
    $scope.searchHotel = "";

    // address fields
    $scope.address = {};

    // discount privilege
    $scope.discount_priviledge = 0;

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    $scope.init = function() {
        $scope.getUsers();
    }

    $scope.addressSave = function() {
        // let form = $('#addressForm');

        // console.log($scope.address.city);



        // if (!$scope.address.city || !$scope.address.state) {
        //     return false;
        // }

        // if (!form.valid()) {
        //     return;
        // }

        $scope.aForm.$submitted = true;
        if (!$scope.aForm.$valid) {
            return;
        }

        if ($scope.formType == 'save') {
            $scope.address.id = $scope.user.addresses.length;
            if ($scope.address.type == 'other') {
                $scope.address.type = $scope.address.other;
            }

            $scope.address.state_id = $scope.address.state.id;
            $scope.address.city_id = $scope.address.city.id;

            $scope.user.addresses.push($scope.address)

            $scope.setPrimary();
        } else {
            $scope.user.addresses = $scope.user.addresses.map((a) => a.id == $scope.address.id ? $scope.address : a);
            $scope.ajaxPost('saveAddress', {
                address: $scope.address,
                frmType: $scope.addressFormType,
                user_id: $scope.user.id
            }, false).then(function(response) {
                if ($scope.addressFormType == "save") {
                    $scope.address.id = response.address.id;
                    if (response.address.primary == 1) {
                        response.address.primary = true;
                    }

                    $scope.user.addresses.push(response.address);
                } else {
                    console.log(response.address);
                    // $scope.user.addresses = $scope.user.addresses.map((u) => )
                }
                $scope.setPrimary();
            }).catch(function(e) {
                console.log(e)
            });
        }
        $('#addNAddress').modal('hide');
    }

    $scope.setAddressValues = function() {
        let i = 0;
        for (i = 0; i < $scope.cities.length; i++) {
            if ($scope.cities[i].id == $scope.address.city_id) {
                $scope.address.city = $scope.cities[i].CityName;
                break;
            }
        }

        for (i = 0; i < $scope.states.length; i++) {
            if ($scope.states[i].id == $scope.address.state_id) {
                $scope.address.state = $scope.states[i].StateName;
                break;
            }
        }
    }

    $scope.setPrimary = function() {
        if ($scope.address.primary) {
            $scope.user.addresses = $scope.user.addresses.map(function(a) {
                if (a.id != $scope.address.id) {
                    a.primary = false;
                }

                return a;
            });
        }
    }

    $scope.addAddress = function() {
        $scope.aForm.$setPristine();
        $scope.aForm.$setUntouched();

        console.log($scope.aForm);
        $scope.address = {
            primary: false,
            state: {},
            city: {}
        };
        $scope.addressFormType = "save";

        $('#addNAddress').modal('show');
    }

    $scope.editAddress = function(address) {
        $scope.aForm.$setPristine();
        $scope.aForm.$setUntouched();

        $scope.address = angular.copy(address);
        $scope.addressFormType = "edit";

        if (address.primary == 1) {
            $scope.address.primary = true;
        }

        $scope.address.state = $scope.states.filter((s) => s.id == $scope.address.state.id)[0];
        $scope.address.city = $scope.cities.filter((c) => c.id == $scope.address.city.id)[0];


        console.log($scope.address);
        $('#addNAddress').modal('show');
    }

    $scope.removeAddress = function(address) {
        if ($scope.formType != "save") {
            $scope.ajaxPost('removeAddress', { id: address.id }, false).then(function(response) {
                console.log(response);
            });
        }
        $scope.user.addresses = $scope.user.addresses.filter((a) => a.id != address.id);
    }

    $scope.getUsers = function() {
        $scope.ajaxGet('getUsers', {
                filters: {
                    name: $scope.searchName,
                    email: $scope.searchEmail,
                    phone: $scope.searchPhone,
                    hotel_id: $scope.searchHotel

                }
            }, true)
            .then(function(response) {
                // console.log(response);
                $scope.users = response.users;
                $scope.cities = response.cities;
                $scope.hotels = response.hotels;
                $scope.states = response.states;
                $scope.departments = response.departments;
                $scope.designations = response.designations;
                $scope.roles = response.roles;
                for (let i = 0; i < $scope.users.length; i++) {
                    $scope.users[i].created_at = moment($scope.users[i].created_at).format('MM/DD/YYYY');
                }
            })
            .catch(function(e) {
                console.log(e);
            })


    }

    $scope.viewCreate = function() {
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();

        $scope.clearPicture();
        $scope.permanentAddress = {};
        $scope.currentAddress = {};
        $scope.formType = "save";
        $scope.user = {
            addresses: []
        };
        $scope.user.roles = [];
        $scope.selectedRoles = [];

        $scope.refType = "";
        $scope.expType = "";

        // console.log($scope.refType);
        // console.log($scope.expType);
        $("#userFormSec").show('slow');
    }
    $scope.hideCreate = function() {
        $("#userFormSec").hide('slow');
    }
    $scope.clearPicture = function(u) {
        document.getElementById('fileLabel').innerHTML = "";
        $(".logo").val('');
        if ($("#preview").attr('src').includes('blob')) {
            $("#preview").attr('src', $("#preview").attr('ng-src'))
        }
        if (u == "user")
            $scope.user.picture = null;
        else
            $scope.user.picture = null;
    }
    $scope.saveUser = function() {
        $scope.myForm.$submitted = true;

        if (!$scope.myForm.$valid) {
            return;
        }

        $scope.user.refType = $scope.refType;
        $scope.user.expType = $scope.expType;

        let formUrl = $scope.formType == "save" ? 'users' : 'users/' + $scope.user.id;

        $scope.ajaxPost(formUrl, $scope.user, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    if (response.success == true) {
                        $scope.myForm.$setPristine();
                        $scope.myForm.$setUntouched();
                        $scope.users.push(response.user);
                        $scope.user = {};
                        $("#userFormSec").hide('slow');
                    }
                } else {
                    if (response.success == true) {
                        $scope.myForm.$setPristine();
                        $scope.myForm.$setUntouched();
                        $scope.users = $scope.users.map((user) => user.id == response.user.id ? response.user : user);
                        $scope.user = {};
                        $("#userFormSec").hide('slow');
                    }
                }


            })
            .catch(function(e) {
                toastr.error(e);
            });
    }


    $scope.editUser = function(u) {
        $scope.myForm.$setPristine();
        $scope.myForm.$setUntouched();



        // console.log(u);
        window.scrollTop();
        $scope.clearPicture();
        $scope.user = {
            addresses: []
        };

        $scope.user = angular.copy(u);

        console.log($scope.user);

        // set addresses
        for (let i = 0; i < $scope.user.addresses.length; i++) {
            for (let j = 0; j < $scope.cities.length; j++) {
                if ($scope.user.addresses[i].city_id == $scope.cities[j].id) {
                    $scope.user.addresses[i].city = $scope.cities[j];
                    break;
                }
            }

            for (let j = 0; j < $scope.states.length; j++) {
                if ($scope.user.addresses[i].state_id == $scope.states[j].id) {
                    $scope.user.addresses[i].state = $scope.states[j];
                    break;
                }
            }
        }

        $scope.user.roles = $scope.user.roles.map((role) => role.id);
        $scope.changeRole();
        // bind experiences
        if (typeof($scope.user.experiences) != 'undefined') {
            if ($scope.user.experiences.length > 0) {
                $scope.user_exp = $scope.user.experiences[0];
                $scope.expType = "Yes";
                $scope.changeExp();
            } else {
                $scope.expType = "No";
                $scope.changeExp();
            }
        }
        if ($scope.user.reference_name != null) {
            $scope.refType = 'Yes';
        } else {
            $scope.refType = 'No';
        }
        $scope.changeRef();
        $scope.formType = "update";
        $('#userFormSec').show('slow');
    }


    $scope.deleteUser = function(u) {
        $scope.user = angular.copy(u);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + u.first_name + "'?",
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
                    $scope.ajaxPost('users/del', $scope.user, false)
                        .then(function(response) {
                            $scope.users = $scope.users.filter((user) => user.id != response.id);
                            $scope.hideCreate();
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }


    $scope.changeExp = function() {
        if ($scope.expType == 'Yes') {
            $(".experience").show('slow');
        } else {
            $(".experience").hide('slow');
        }
    }
    $scope.changeRef = function() {
        if ($scope.refType == 'Yes') {
            $(".reference").show('slow');
        } else {
            $(".reference").hide('slow');
        }
    }
    $scope.showAddressModal = function(frmType) {
        $scope.addressFormType = frmType;
        for (let i = 0; i < $scope.user.addresses; i++) {
            if ($scope.user.addresses[i].type == 'permanent') {
                $scope.permanentAddress = $scope.user.addresses[i];
            } else {
                $scope.currentAddress = $scope.user.addresses[i];
            }
        }

        $('#addNAddress').modal('show');
    }

    $scope.showFilter = function() {
        $('#filterFrm').toggle();
    }

    $scope.hideFilter = function() {
        $('#filterFrm').toggle();
    }

    $scope.hideAddressModal = function() {
        $('#addNAddress').modal('hide');
    }

    // $scope.showAddresses = function() {
    //     // console.log($scope.permanentAddress);
    //     // console.log($scope.currentAddress);

    //     $scope.user.addresses = [];
    //     if ($scope.permanentAddress.address) {
    //         if ($scope.permanentAddress.address.trim().length > 0) {
    //             $scope.permanentAddress.type = 'permanent';
    //             $scope.user.addresses.push($scope.permanentAddress);
    //         }
    //     }

    //     if ($scope.currentAddress.address) {
    //         if ($scope.currentAddress.address.trim().length > 0) {
    //             $scope.currentAddress.type = 'current';
    //             $scope.user.addresses.push($scope.currentAddress);
    //         }
    //     }
    //     // console.log($scope.user.addresses[1]);

    //     $('#addNAddress').modal('hide');
    //     $('#mediaList').show();
    // }

    $scope.resendPassword = function(id) {
        console.log(id);
        $scope.ajaxPost('/resendPassword', {
                id: id
            }, false)
            .then(function(response) {

            })
            .catch(function(e) {
                toastr.error(e);
            })
    }

    $scope.checkRole = function(id) {
        // console.log($scope.user.roles);
        let idx = $scope.user.roles.indexOf(id);

        if (idx > -1) {
            $scope.user.roles.splice(idx, 1);
        } else {
            $scope.user.roles.push(id);
        }

        console.log($scope.user.roles);
    }

    $scope.resetFilters = function() {
        $scope.searchName = "";
        $scope.searchEmail = "";
        $scope.searchPhone = "";
        scope.searchHotel = "";
        $scope.getUsers();
    }

    $scope.changeRole = function() {
        let selected_role = $scope.roles.filter((r) => r.id == $scope.user.roles[0]);

        if (selected_role[0].has_discount_priviledge == "1") {
            $scope.discount_priviledge = "1";
        } else {
            $scope.discount_priviledge = "0";
        }
    }
});
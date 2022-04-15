app.controller('roleCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {

    $scope.roleForm = {};
    $scope.selectAllPermissions = false;
    $scope.selectAllGroup = {};
    $scope.AssignUsers = {};
    $scope.landingPageOptions = [];

    first = true;
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers').withDOM("<'row'<'col-sm-12'tr>>" +
        "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>").withOption('stateSave', true);
    $scope.dtColumnDefs = [
        // DTColumnDefBuilder.newColumnDef([3]).notSortable()
    ];

    $scope.module = {};
    $scope.roleRow = function(module) {
        $scope.role = module;
        $(event.currentTarget).addClass('selectedtr');
        $('#roleAction').modal('show');
    }

    $scope.revert = function() {
        $scope.myForm.$setPristine();
    }

    $scope.hideForm = function() {
        $('#role-form-section').hide('slow');
    }

    $scope.createRole = function() {
        console.log($scope.roleForm);
        if ($scope.roleForm.id) {
            delete $scope.roleForm.users_count;
        }
        // return;
        $scope.ajaxPost('addRole', JSON.parse(angular.toJson($scope.roleForm))).then(function(response) {
            if (response.success) {

                $scope.getRoles();
                if ($scope.roleForm.id == null) {
                    bootbox.dialog({
                        title: 'Confirm Add?',
                        message: "Do you want to assign staff member's on this role?",
                        buttons: {
                            yes: {
                                label: 'Yes',
                                className: 'btn-success',
                                callback: function() {
                                    $scope.roleForm.id = response.id;
                                    $scope.getRoleUsers($scope.roleForm.id);
                                }
                            },
                            no: {
                                label: 'No',
                                className: 'btn-danger',
                                callback: function() {
                                    $('#role-form-section').hide('slow');
                                    // block.unblock();
                                }
                            },

                        },
                    });

                } else {
                    $scope.roleForm = {};
                    $scope.myForm.$setPristine();
                    setTimeout(function() {
                            $('#role-form-section').hide('slow');
                            // block.unblock();
                        },
                        100);
                }
            }
        })
    }


    $scope.checkAvailable = function() {
        $scope.showAssign = Object.keys($scope.AssignUsers)
            .filter(function(k) { return $scope.AssignUsers[k] == true })
            .map(Number).length > 0;
    }

    $scope.AssignRoleToUser = function() {

        $scope.ajaxPost('assignUserRole', { users: $scope.AssignUsers, role: $scope.roleForm.id })
            .then(function(response) {
                if (response.success) {
                    $scope.getRoleUsers($scope.roleForm.id);
                }
            })
    }

    $scope.getRolesName = function(roles, trim) {
        return Array.prototype.map.call(roles, function(item) { return item.display_name; }).join(", ")

    }

    $scope.RemoveIndividualRole = function(user) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete the ' + $scope.roleForm.name + ' role of ' + user.name,
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
                    $scope.ajaxPost('removeUserRole', { id: user.id, role: $scope.roleForm.id })
                        .then(function(response) {
                            if (!response.errors) {
                                $scope.getRoleUsers($scope.roleForm.id);
                            }
                        })
                }
            }
        });
    }


    $scope.getRoles = function() {

        // ShowLoaderTb();
        $scope.ajaxGet('getRolesData', {}, true)
            .then(function(response) {
                // HideLoaderTb();
                if (response.success) {
                    $scope.roles = response.payload;
                }
                setTimeout(() => {
                    $('[data-popup="popover"]').popover();
                }, 500);

            })

        $scope.ajaxGet('getPermissions', {}, true)
            .then(function(response) {
                if (response.success) {
                    // HideLoaderTb();
                    $scope.permissions = response.payload;
                    $scope.permissiongroup = $scope.removeDuplicates($scope.permissions, "group");
                }
            })
    }

    $scope.removeDuplicates = function(myArr, prop) {
        return myArr.filter((obj, pos, arr) => {
            return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
        });
    }

    $scope.getRoleUsers = function(roleID) {
        $scope.ajaxGet('getRolesUserData', { id: roleID }, true)
            .then(function(response) {
                if (response.success) {
                    var res = response.payload;
                    // console.log(res);
                    $scope.assignedusers = res["assignedusers"];
                    $scope.availableusers = res["availableusers"];
                }

            })
    }

    $scope.showRoleForm = function(roleID) {
        $scope.view = false;
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
        $scope.selectAllGroup = {};
        $scope.AssignUsers = {};
        $scope.landingPageOptions = [];
        $scope.roleForm = {};
        $scope.showAssign = false;
        $('.admin-form-section.card-collapsed').removeClass('card-collapsed').find('.card-body').show();
        $('.admin-form-section.rotate-180').removeClass('rotate-180');
        $scope.selectAllPermissions = false;
        $('#roleAction').modal('hide');
        $('.selectedtr').removeClass('selectedtr');
        if (roleID) {
            $scope.roleForm = angular.copy(Object.values($scope.roles).find(role => role.id == roleID));
            $scope.getRoleUsers($scope.roleForm.id);
            if ($scope.permissions.length == Object.keys($scope.roleForm.permissions).length) {
                $scope.selectAllPermissions = true;
                $scope.permissiongroup.forEach(element => {
                    $scope.selectAllGroup[element.group] = true;
                });

            } else {
                count = 0;

                $scope.permissiongroup.forEach(element => {
                    var group = element.group;

                    var gp = Object.values($scope.permissions).filter(function(obj) {
                        return obj.group == group
                    }).map(function(obj) { return obj.id });
                    var n = Object.values(gp).filter(function(obj) {
                        return $scope.roleForm.permissions[obj] == false || $scope.roleForm.permissions[obj] == undefined
                    });
                    var m = Object.values(gp).filter(function(obj) {
                        return $scope.roleForm.permissions[obj] == true
                    });
                    if (n.length == 0) {

                        $scope.selectAllGroup[group] = true;
                        count++;
                    } else {
                        $scope.selectAllGroup[group] = false;
                    }
                    $scope.selectAllPermissions = (count == $scope.permissiongroup.length)

                });


            }

            $scope.permissions.forEach(perm => {
                if ($scope.roleForm.permissions[perm.id] && perm.url) {
                    $scope.landingPageOptions.push({ url: perm.url, name: perm.view_name });
                }
            })
            $exist = $.grep($scope.landingPageOptions, function(elem, index) {
                console.log(elem);
                return elem.url == $scope.roleForm.landing_page;



            });
            if ($exist.length < 1) {
                $scope.roleForm.landing_page = null;
            }
        }
        setTimeout(function() {
                $('#role-form-section').show('slow');
            },
            100);
    }
    $scope.view = false;

    $scope.viewRoleForm = function(roleID) {
        $scope.view = true;
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
        $scope.selectAllGroup = {};
        $scope.AssignUsers = {};
        $scope.landingPageOptions = [];
        $scope.roleForm = {};
        $scope.showAssign = false;
        $('.admin-form-section.card-collapsed').removeClass('card-collapsed').find('.card-body').show();
        $('.admin-form-section.rotate-180').removeClass('rotate-180');
        $scope.selectAllPermissions = false;
        $('#roleAction').modal('hide');
        $('.selectedtr').removeClass('selectedtr');
        if (roleID) {
            $scope.roleForm = angular.copy(Object.values($scope.roles).find(role => role.id == roleID));
            $scope.getRoleUsers($scope.roleForm.id);
            if ($scope.permissions.length == Object.keys($scope.roleForm.permissions).length) {
                $scope.selectAllPermissions = true;
                $scope.permissiongroup.forEach(element => {
                    $scope.selectAllGroup[element.group] = true;
                });

            } else {
                count = 0;

                $scope.permissiongroup.forEach(element => {
                    var group = element.group;

                    var gp = Object.values($scope.permissions).filter(function(obj) {
                        return obj.group == group
                    }).map(function(obj) { return obj.id });
                    var n = Object.values(gp).filter(function(obj) {
                        return $scope.roleForm.permissions[obj] == false || $scope.roleForm.permissions[obj] == undefined
                    });
                    var m = Object.values(gp).filter(function(obj) {
                        return $scope.roleForm.permissions[obj] == true
                    });
                    if (n.length == 0) {

                        $scope.selectAllGroup[group] = true;
                        count++;
                    } else {
                        $scope.selectAllGroup[group] = false;
                    }
                    $scope.selectAllPermissions = (count == $scope.permissiongroup.length)

                });


            }

            $scope.permissions.forEach(perm => {
                if ($scope.roleForm.permissions[perm.id] && perm.url) {
                    $scope.landingPageOptions.push({ url: perm.url, name: perm.view_name });
                }
            })
            $exist = $.grep($scope.landingPageOptions, function(elem, index) {
                console.log(elem);
                return elem.url == $scope.roleForm.landing_page;



            });
            if ($exist.length < 1) {
                $scope.roleForm.landing_page = null;
            }
        }
        setTimeout(function() {
                $('#role-form-section').show('slow');
            },
            100);
    }

    $scope.removeRole = function(role) {

        // if (role.is_system) {
        //     alert("You cannot delete system roles!");
        //     return;
        // }
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete ' + role.name + ' role?',
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
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth',
                    });
                    $scope.ajaxPost('removeRole', { id: role.id })
                        .then(function(response) {
                            // console.log(response);
                            if (!response.errors) {
                                $('#roleAction').modal('hide');
                                $('.selectedtr').removeClass('selectedtr');
                                $scope.getRoles();
                                // block.unblock();
                            }
                        })
                }
            }
        });

    }

    $scope.selectAllgroupPermission = function(group, asd) {

        var gp = Object.values($scope.permissions).filter(function(obj) {
            return obj.group == group
        }).map(function(obj) { return obj.id });



        if ($scope.roleForm.permissions == undefined)
            $scope.roleForm.permissions = {};
        if (asd) {

            gp.forEach(element => {
                $scope.roleForm.permissions[element] = true;
            });
        } else {
            gp.forEach(element => {
                $scope.roleForm.permissions[element] = false;
            });
        }
        $scope.adjusttoggle();

        $scope.landingPages = [];
        $scope.permissions.forEach(perm => {
            if ($scope.roleForm.permissions[perm.id] && perm.url) {
                $scope.landingPages.push({ url: perm.url, name: perm.view_name });
            }
        })

    }

    $scope.selectabcd = function(group, asd) {
        var gp = Object.values($scope.permissions).filter(function(obj) {
            return obj.group == group
        }).map(function(obj) { return obj.id });
        var n = Object.values(gp).filter(function(obj) {
            return $scope.roleForm.permissions[obj] == false || $scope.roleForm.permissions[obj] == undefined
        });
        var m = Object.values(gp).filter(function(obj) {
            return $scope.roleForm.permissions[obj] == true
        });
        if (n.length == 0)
            $scope.selectAllGroup[group] = true;
        else
            $scope.selectAllGroup[group] = false;


        $scope.adjusttoggle();

        $scope.landingPageOptions = [];
        $scope.permissions.forEach(perm => {
            if ($scope.roleForm.permissions[perm.id] && perm.url) {
                $scope.landingPageOptions.push({ url: perm.url, name: perm.view_name });
            }
        })

        // console.log($scope.roleForm.landing_page);
        $exist = $.grep($scope.landingPageOptions, function(elem, index) {
            console.log(elem);
            return elem.url == $scope.roleForm.landing_page;



        });
        if ($exist.length < 1) {
            $scope.roleForm.landing_page = null;
        }
        // console.log($a);


    }

    $scope.adjusttoggle = function() {
        count = 0;
        $scope.permissiongroup.forEach(element => {
            if ($scope.selectAllGroup[element.group])
                count++;
        });
        $scope.selectAllPermissions = (count == $scope.permissiongroup.length);

    }
    $scope.selectAll = function() {

        $scope.landingPageOptions = [];
        if ($scope.roleForm.permissions == undefined)
            $scope.roleForm.permissions = {};
        $scope.permissions.forEach(element => {
            $scope.roleForm.permissions[element.id] = $scope.selectAllPermissions;
            if ($scope.roleForm.permissions[element.id] && element.url) {
                $scope.landingPageOptions.push({ url: element.url, name: element.view_name });
            }
        });
        $scope.permissiongroup.forEach(element => {
            $scope.selectAllGroup[element.group] = $scope.selectAllPermissions;
        });

        //console.log($scope.roleForm.permissions);


        // $scope.roleForm.permissions.forEach(element => {
        // 	console.log(element);
        // 	//$scope.roleForm.permissions[element.id]=true;
        // });
    }
    $scope.filterRoles = function(searchFields) {
        // ShowLoaderTb();
        $scope.ajaxGet('getRolesData', searchFields, true)
            .then(function(response) {
                // HideLoaderTb();
                if (response.success) {
                    $scope.roles = response.payload;
                    console.log($scope.roles)
                }

            })

    }

});
app.controller('typemanagementCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.channels = {};
    $scope.channel = {};

    $scope.servicetypes = {};
    $scope.servicetype = {};


    $scope.roomtypes = {};
    $scope.roomtype = {};

    $scope.relations = {};
    $scope.relation = {};

    $scope.taxrates = {};
    $scope.taxrate = {};
    $scope.taxrate.IsDefault = 0;

    $scope.formType = "save";


    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    //********************************** FUNCTIONS *******************************// 

    $scope.init = function() {
        $scope.getTypeManagement();
    }

    $scope.getTypeManagement = function() {
            $scope.ajaxGet('getTypeManagement', {}, true)
                .then(function(response) {
                    $scope.contacttypes
                    $scope.contacttypes = response.contacttypes;
                    $scope.servicetypes = response.servicetypes;
                    $scope.roomtypes = response.roomtypes;
                    $scope.relations = response.relations;
                    $scope.taxrates = response.taxrates;
                    $scope.channels = response.channels;
                    console.log(response);

                })
                .catch(function(e) {
                    console.log(e);
                })
        }
        // for channel
    $scope.addChannel = function() {
        $scope.channel = {};
        $scope.formType = "save";
        $("#channelModal").modal('show');
    }

    $scope.saveChannel = function() {
        // Save record
        $scope.ChannelForm.$submitted = true;
        if (!$scope.ChannelForm.$valid) {
            return;
        }

        $scope.ajaxPost('types/saveChannel', { channel: $scope.channel, formType: $scope.formType }, false).then(function(response) {
            if (response.success) {
                $scope.init();
            }
            $scope.channel = {};
            $("#channelModal").modal('hide');
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editChannel = function(c) {
        $("#channelModal").modal('show');
        $scope.formType = "edit";
        $scope.channel = angular.copy(c);
        console.log($scope.channel);
    }

    $scope.deleteChannel = function(c) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + c.Channel + "?",
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
                if (!result)
                    return;
                $scope.ajaxPost('types/deleteChannel', { id: c.id, channel: c }, false).then(function(response) {
                    $scope.channels = $scope.channels.filter((c) => c.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }

    // for service type

    $scope.addSType = function() {
        $scope.formType = "save";
        $scope.servicetype = {};
        $("#sTypeAdd").show();
    }

    $scope.closeStypebtn = function() {
        $("#sTypeAdd").hide();
    }

    $scope.saveSType = function() {
        // for validation
        let f = $('#STypeForm');
        if (!f.valid()) {
            return;
        }
        // Save record
        $scope.ajaxPost('types/saveSType', { servicetype: $scope.servicetype, formType: $scope.formType }, false).then(function(response) {
            if (response.success) {
                if ($scope.formType == "save") {
                    $scope.servicetypes.push(response.servicetype);
                } else {
                    $scope.servicetypes = $scope.servicetypes.map((st) => st.id == response.servicetype.id ? response.servicetype : st);
                }
                $scope.servicetype = {};
                $("#sTypeAdd").hide();
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editSType = function(st) {
        $("#sTypeAdd").show();
        $scope.formType = "edit";
        $scope.servicetype = angular.copy(st);
        console.log($scope.servicetype);
    }

    $scope.deleteSType = function(st) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + st.ServiceType + "?",
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
                if (!result)
                    return;
                $scope.ajaxPost('types/deleteSType', { id: st.id }, false).then(function(response) {
                    $scope.servicetypes = $scope.servicetypes.filter((st) => st.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }



    // for room type
    $scope.addRType = function() {
        $scope.formType = "save";
        $scope.roomtype = {};
        $("#rTypeAdd").show();
    }
    $scope.closeRtypebtn = function() {
        $("#rTypeAdd").hide();
    }

    $scope.saveRType = function() {
        // for validation
        let f = $('#RTypeForm');
        if (!f.valid()) {
            return;
        }
        // Save record
        $scope.ajaxPost('types/saveRType', { roomtype: $scope.roomtype, formType: $scope.formType }, false).then(function(response) {
            if (response.success) {
                if ($scope.formType == "save") {
                    $scope.roomtypes.push(response.roomtype);
                } else {
                    $scope.roomtypes = $scope.roomtypes.map((rt) => rt.id == response.roomtype.id ? response.roomtype : rt);
                }
                $scope.roomtype = {};
                $("#rTypeAdd").hide();
            }

        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editRType = function(rt) {
        $("#rTypeAdd").show();
        $scope.formType = "edit";
        $scope.roomtype = angular.copy(rt);
        console.log($scope.roomtype);
    }

    $scope.deleteRType = function(rt) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + rt.RoomType + "?",
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
                if (!result)
                    return;
                $scope.ajaxPost('types/deleteRType', { id: rt.id }, false).then(function(response) {
                    $scope.roomtypes = $scope.roomtypes.filter((rt) => rt.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }




    // for Relation 
    $scope.addRel = function() {
        $scope.formType = "save";
        $scope.relation = {};
        $("#relAdd").show();
    }

    $scope.closeRelbtn = function() {
        $("#relAdd").hide();
    }

    $scope.saveRel = function() {
        // for validation
        let f = $('#RelForm');
        if (!f.valid()) {
            return;
        }
        // Save record
        $scope.ajaxPost('types/saveRel', { relation: $scope.relation, formType: $scope.formType }, false).then(function(response) {
            if (response.success) {
                if ($scope.formType == "save") {
                    $scope.relations.push(response.relation);
                } else {
                    $scope.relations = $scope.relations.map((rel) => rel.id == response.relation.id ? response.relation : rel);
                }
                $scope.relation = {};
                $("#relAdd").hide();
            }


        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editRel = function(rel) {
        $("#relAdd").show();
        $scope.formType = "edit";
        $scope.relation = angular.copy(rel);
        console.log($scope.relation);


    }

    $scope.deleteRel = function(rel) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + rel.Relation + "?",
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
                if (!result)
                    return;
                $scope.ajaxPost('types/deleteRel', { id: rel.id }, false).then(function(response) {
                    $scope.relations = $scope.relations.filter((rel) => rel.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }



    //for taxrates 

    $scope.addTaxRate = function() {
        $scope.formType = "save";
        $scope.taxrate = {};
        $scope.taxrate.IsDefault = false;
        $("#taxRateModal").modal('show');
    }

    $scope.saveTaxRate = function() {
        let f = $('#TaxRateForm');
        if (!f.valid()) {
            return;
        }
        if ($scope.taxrate.IsDefault) {
            $scope.taxrate.IsDefault = 1;
        } else {
            $scope.taxrate.IsDefault = 0;

        }

        $scope.ajaxPost('types/saveTaxRate', { taxrate: $scope.taxrate, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                if ($scope.formType == "save") {
                    $scope.taxrates.push(response.taxrate);
                } else {
                    $scope.taxrates = $scope.taxrates.map((tx) => tx.id == response.taxrate.id ? response.taxrate : tx);
                }
                $('#taxRateModal').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editTaxRate = function(tx) {
        $scope.formType = "edit";
        $scope.taxrate = angular.copy(tx);
        console.log($scope.taxrate);

        if ($scope.taxrate.IsDefault == 1) {
            $scope.taxrate.IsDefault = true;
        } else {
            $scope.taxrate.IsDefault = false;

        }

        $('#taxRateModal').modal('show');
    }

    $scope.deleteTaxRate = function(tx) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + tx.Tax + "?",
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
                if (!result)
                    return;
                $scope.ajaxPost('types/deleteTaxRate', { id: tx.id }, false).then(function(response) {
                    $scope.taxrates = $scope.taxrates.filter((tx) => tx.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }



});
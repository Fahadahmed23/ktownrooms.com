app.controller('departmentCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.departments = [];
    $scope.department = {};
    $scope.formType = "";
    $scope.serviceFormType = "";

    // service fields
    $scope.service = {};

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    //********************************** FUNCTIONS *******************************// 

    $scope.init = function() {
        $scope.getnDepartments();
        $scope.getIcons();
    }

    $scope.bg_colors = [
        { id: 1, name: "Bright Blue", bg_class: "bg-primary" },
        { id: 1, name: "Bright Green", bg_class: "bg-success" },
        { id: 1, name: "Red", bg_class: "bg-danger" },
        { id: 1, name: "Orange", bg_class: "bg-warning" },
        { id: 1, name: "Pink", bg_class: "bg-pink" },
        { id: 1, name: "Indigo", bg_class: "bg-indigo" },
        { id: 1, name: "Light Blue", bg_class: "bg-info" },
        { id: 1, name: "Black", bg_class: "bg-dark" },
        { id: 1, name: "Light Grey", bg_class: "bg-light" }
    ]

    $scope.getIcons = function() {
        $scope.ajaxGet('getIcons', {}, true)
            .then(function(response) {
                $scope.fontawsomeicons = response;
                console.log($scope.fontawsomeicons);
            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.clearPicture = function(d) {
        document.getElementById('fileLabel').innerHTML = "";
        if (d == "department") {
            $scope.department.IconPath = null;
        } else {
            $scope.department.IconPath = null;
        }
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getnDepartments = function() {
        $scope.ajaxGet('getnDepartments', {}, true)
            .then(function(response) {
                // $scope.services = response.services;
                $scope.departments = response.departments;
                // $scope.servicetypes = response.servicetypes;
                $scope.companies = response.companies;

                console.log(response.departments);

            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.editDepartment = function(d) {
        window.scrollTop();
        $scope.deparmentForm.$setPristine();
        $scope.deparmentForm.$setUntouched();
        $scope.department = angular.copy(d);
        $scope.formType = "update";
        $('#addNewDepartment').show('slow');
        console.log($scope.department);
    }


    $scope.createDepartment = function() {
        $scope.deparmentForm.$setPristine();
        $scope.deparmentForm.$setUntouched();
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewDepartment').show('slow');
        $scope.department = {
            // services: [],
            IsClientService: 0
        };
        console.log("here");

    }

    $scope.saveDepartment = function() {

        $scope.deparmentForm.$submitted = true;
        if (!$scope.deparmentForm.$valid) {
            return;
        }
        if (!$scope.department.IconPath) {
            toastr.error("Please upload department icon");
            return;
        }

        let formUrl = $scope.formType == "save" ? 'ndepartments' : 'ndepartments/' + $scope.department.id;

        $scope.ajaxPost(formUrl, $scope.department, false)
            .then(function(response) {
                if (response.success) {
                    if ($scope.formType == "save") {
                        $scope.departments.push(response.department);
                    } else {
                        $scope.departments = $scope.departments.map((department) => department.id == $scope.department.id ? $scope.department : department)
                    }
                    $scope.department = {};
                    $('#addNewDepartment').hide('slow');
                    $scope.getnDepartments();
                }

            })
            .catch(function(e) {
                console.log(response);
            });
    }

    $scope.deleteDepartment = function(c) {
        $scope.department = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.Department + "'?",
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
                    $scope.ajaxPost('ndepartments/del', { department: $scope.department }, false)
                        .then(function(response) {
                            if (response.success == true) {
                                $scope.departments = $scope.departments.filter((service) => service.id != c.id);
                            }
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewDepartment').hide('slow');
    }


    // $scope.addService = function() {
    //     $scope.serviceForm.$setPristine();
    //     $scope.serviceForm.$setUntouched();
    //     $scope.service = {};
    //     $scope.serviceFormType = 'save';
    //     $('#addService').modal('show');
    // }
    // $scope.hideServiceModal = function() {
    //     $('#addService').modal('hide');
    // }


    // $scope.serviceSave = function() {

    //     $scope.serviceForm.$submitted = true;
    //     if (!$scope.serviceForm.$valid) {
    //         return;
    //     }
    //     if ($scope.formType == "save") {
    //         if ($scope.serviceFormType == 'save') {

    //             $scope.service.id = $scope.department.services.length;
    //             $scope.department.services.push($scope.service);

    //         } else {
    //             $scope.department.services = $scope.department.services.map((s) => s.id == $scope.service.id ? $scope.service : s);
    //         }
    //         $scope.service = {};
    //     } else {
    //         $scope.ajaxPost('saveService', {
    //             service: $scope.service,
    //             formType: $scope.serviceFormType,
    //             department_id: $scope.department.id
    //         }, false).then(function(response) {
    //             if ($scope.serviceFormType == "save") {
    //                 // if (response.success) {
    //                 $scope.department.services.push(response.service);
    //             } else {
    //                 $scope.department.services = $scope.department.services.map((a) => a.id == $scope.service.id ? $scope.service : a);
    //             }
    //         }).catch(function(e) {
    //             console.log(e)
    //         });
    //     }

    //     console.log($scope.department.services);

    //     $('#addService').modal('hide');
    // }






    // $scope.editService = function(s) {
    //     $scope.serviceForm.$setPristine();
    //     $scope.serviceForm.$setUntouched();
    //     $scope.serviceFormType = 'edit';
    //     $scope.service = angular.copy(s);
    //     $('#addService').modal('show');
    // }

    // $scope.deleteService = function(s) {
    //     $scope.service = angular.copy(s);
    //     bootbox.confirm({
    //         title: 'Confirm Deletion',
    //         message: "Are you sure you want to delete '" + s.Service + "'?",
    //         buttons: {
    //             confirm: {
    //                 label: 'Yes',
    //                 className: 'btn-primary'
    //             },
    //             cancel: {
    //                 label: 'Cancel',
    //                 className: 'btn-link'
    //             }
    //         },
    //         callback: function(result) {
    //             if (result) {
    //                 if ($scope.formType == 'save') {
    //                     $scope.department.services = $scope.department.services.filter((service) => service.id != s.id);
    //                     $scope.service = {};
    //                     $scope.$apply();
    //                 } else {
    //                     $scope.ajaxPost('removeService', { id: $scope.service.id }, false)
    //                         .then(function(response) {
    //                             $scope.department.services = $scope.department.services.filter((service) => service.id != response.id);
    //                         })
    //                         .catch(function(e) {
    //                             toastr.error(e);
    //                         })
    //                 }



    //             }
    //         }
    //     });
    // }


});
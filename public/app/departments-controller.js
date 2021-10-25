app.controller('departmentsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.departments = [];

    $scope.department = {};

    $scope.formType = "";

    $scope.filterSearchText = "";

    $scope.companies = [];

    $scope.company = {};

    $scope.cities = [];

    $scope.city = {};

    $scope.states = [];

    $scope.state = {};

    //$scope.errors = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {

        $scope.getDepartments();
        $scope.getCompanies();
        $scope.getStates();
    }

    $scope.getDepartments = function() {
        $scope.ajaxGet('getDepartments', {}, true)
            .then(function(response) {
                $scope.departments = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }


    $scope.getCompanies = function() {
        $scope.ajaxGet('getCompanies', {}, true)
            .then(function(response) {
                $scope.companies = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.getStates = function() {
        $scope.ajaxGet('getStates', {}, true)
            .then(function(response) {
                $scope.states = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.editDepartment = function(c) {
        $scope.department = angular.copy(c);
        $scope.formType = "update";

        $('#addNewDepartment').show('slow');
        $('#searchDepartment').hide();
    }


    $scope.createDepartment = function() {
        $scope.department = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewDepartment').show('slow');
        $('#searchDepartment').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveDepartment = function() {

        let form = $(".form-validate-jquery");
        console.log(form.valid());
        if (form.valid() == false) {
            return;
        }


        let formUrl = $scope.formType == "save" ? 'departments' : 'departments/' + $scope.department.id;

        $scope.ajaxPost(formUrl, $scope.department, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.departments.push(response.department);
                } else {
                    $scope.departments = $scope.departments.map((department) => department.id == $scope.department.id ? $scope.department : department)
                }

                $scope.department = {};
            })
            .catch(function(e) {
                console.log(response);
            });

        $scope.getDepartments();
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
                    $scope.ajaxPost('departments/del', { id: $scope.department.id }, false)
                        .then(function(response) {
                            $scope.departments = $scope.departments.filter((department) => department.id != response.id);
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
});
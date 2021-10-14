app.controller('companiesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {

    // variables
    $scope.companies = [];

    $scope.company = {};

    $scope.formType = "";

    $scope.filterSearchText = "";

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

        $scope.getCompanies();
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
    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }


    $scope.editCompany = function(c) {
        $scope.companyForm.$setPristine();
        $scope.companyForm.$setUntouched();

        $scope.company = angular.copy(c);
        $scope.formType = "update";

        $('#addNewCompany').show('slow');
        $('#searchCompany').hide();
    }


    $scope.createCompany = function() {
        $scope.companyForm.$setPristine();
        $scope.companyForm.$setUntouched();

        $scope.company = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewCompany').show('slow');
        $('#searchCompany').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.saveCompany = function() {
        // let f = $("#companyForm");
        // if (!f.valid()) {
        //     return;
        // }

        $scope.companyForm.$submitted = true;
        if (!$scope.companyForm.$valid) {
            return;
        }


        let formUrl = $scope.formType == "save" ? 'companies' : 'companies/' + $scope.company.id;

        $scope.ajaxPost(formUrl, $scope.company, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.companies.push(response.company);
                } else {
                    $scope.companies = $scope.companies.map((company) => company.id == $scope.company.id ? $scope.company : company)
                }

                $scope.company = {};
                $scope.getCompanies();
                $('#addNewCompany').hide('slow');

            })
            .catch(function(e) {
                console.log(response);
            });
    }

    $scope.deleteCompany = function(c) {
        $scope.company = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.CompanyName + "'?",
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
                    $scope.ajaxPost('companies/del', { id: $scope.company.id, CompanyName: $scope.company.CompanyName }, false)
                        .then(function(response) {
                            $scope.companies = $scope.companies.filter((company) => company.id != response.id);
                            $('#addNewCompany').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewCompany').hide('slow');
    }
});
app.controller('localeCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    $scope.countries = [];
    $scope.states = [];
    $scope.cities = [];

    $scope.country = {};
    $scope.state = {};
    $scope.city = {};

    $scope.formType = "save";

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([1]).notSortable()
    ];

    $scope.init = function() {
        $scope.ajaxPost('locale/initData', {}, true).then(function(response) {
            $scope.countries = response.countries;
            $scope.states = response.states;
            $scope.cities = response.cities;
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.deleteCountry = function(c) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + c.CountryName + "?",
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
                $scope.ajaxPost('locale/deleteCountry', { id: c.id }, false).then(function(response) {
                    $scope.countries = $scope.countries.filter((c) => c.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });

    }

    $scope.deleteState = function(s) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + s.StateName + "?",
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
                $scope.ajaxPost('locale/deleteState', { id: s.id }, false).then(function(response) {
                    $scope.states = $scope.states.filter((s) => s.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }

    $scope.deleteCity = function(c) {
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to Delete '" + c.CityName + "?",
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
                $scope.ajaxPost('locale/deleteCity', { id: c.id }, false).then(function(response) {
                    $scope.cities = $scope.cities.filter((c) => c.id != response.id);
                }).catch(function(e) {
                    console.log(e);
                });
            }
        });
    }

    $scope.addCountry = function() {
        $scope.countryForm.$setPristine();
        $scope.countryForm.$setUntouched();

        $scope.formType = "save";
        $scope.country = {};

        $('#country_form').modal('show');
    }

    $scope.addState = function() {
        $scope.stateForm.$setPristine();
        $scope.stateForm.$setUntouched();

        $scope.formType = "save";
        $scope.state = {};

        $('#state_form').modal('show');
    }

    $scope.addCity = function() {
        $scope.cityForm.$setPristine();
        $scope.cityForm.$setUntouched();

        $scope.formType = "save";
        $scope.city = {};

        $('#city_form').modal('show');
    }

    $scope.saveCountry = function() {
        // let f = $('#v_country');

        // if (!f.valid()) {
        //     return;
        // }

        $scope.countryForm.$submitted = true;
        if (!$scope.countryForm.$valid) {
            return;
        }

        $scope.ajaxPost('locale/saveCountry', { country: $scope.country, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                if ($scope.formType == "save") {
                    $scope.countries.push(response.country);
                } else {
                    $scope.countries = $scope.countries.map((c) => c.id == response.country.id ? response.country : c);
                }


                $('#country_form').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.saveHotelCategory = function() {

    
        // let f = $('#v_country');

        // if (!f.valid()) {
        //     return;
        // }

        $scope.hotelcategoryForm.$submitted = true;
        if (!$scope.hotelcategoryForm.$valid) {
            return;
        }

        $scope.ajaxPost('locale/saveHotelCategory', { hotelcategory: $scope.hotelcategory, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {
                if ($scope.formType == "save") {
                    $scope.hotel_categories.push(response.hotel);
                } else {
                    $scope.hotel_categories = $scope.hotel_categories.map((c) => c.id == response.hotel.id ? response.hotel : c);
                }

                $('#hotelcategory_form').modal('hide');
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.saveState = function() {
        // let f = $('#v_state');

        // if (!f.valid()) {
        //     return;
        // }

        $scope.stateForm.$submitted = true;
        if (!$scope.stateForm.$valid) {
            return;
        }

        $scope.ajaxPost('locale/saveState', { state: $scope.state, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {


                if ($scope.formType == "save") {
                    $scope.states.push(response.state);
                } else {
                    $scope.states = $scope.states.map((s) => s.id == response.state.id ? response.state : s);
                }


                $('#state_form').modal('hide');

            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.saveCity = function() {
        // let f = $('#v_city');

        // if (!f.valid()) {
        //     return;
        // }

        $scope.cityForm.$submitted = true;
        if (!$scope.cityForm.$valid) {
            return;
        }

        $scope.ajaxPost('locale/saveCity', { city: $scope.city, formType: $scope.formType }, false).then(function(response) {
            if (response.success == true) {


                if ($scope.formType == "save") {
                    $scope.cities.push(response.city);
                } else {
                    $scope.cities = $scope.cities.map((c) => c.id == response.city.id ? response.city : c);
                }

                // if (response.success == true) {
                $('#city_form').modal('hide');
                // }
            }
        }).catch(function(e) {
            console.log(e);
        });
    }

    $scope.editCountry = function(c) {
        $scope.countryForm.$setPristine();
        $scope.countryForm.$setUntouched();

        $scope.formType = "edit";
        $scope.country = angular.copy(c);

        $('#country_form').modal('show');
    }

    $scope.editState = function(s) {
        $scope.stateForm.$setPristine();
        $scope.stateForm.$setUntouched();

        $scope.formType = "edit";
        $scope.state = angular.copy(s);

        $('#state_form').modal('show');
    }

    $scope.editCity = function(c) {
        $scope.cityForm.$setPristine();
        $scope.cityForm.$setUntouched();

        $scope.formType = "edit";
        $scope.city = angular.copy(c);

        $('#city_form').modal('show');
    }
});
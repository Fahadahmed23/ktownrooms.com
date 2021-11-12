app.controller('incomeStatementCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.ledger = {};
    // $scope.account_heads = {};
    $scope.formType = "";
    $scope.errors = [];
    $scope.zero_records = 0;

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row m-0'<'col-sm-12'tr>>" +
            "<'row p-2 m-0 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];


    // functions
    $scope.init = function() {
        $scope.getLevels_FiscalYear();
    }


    $scope.getLevels_FiscalYear = function() {
        $scope.ajaxGet('levels_fiscalyears', {}, true)
            .then(function(response) {
                $scope.levels = response.levels;
                $scope.fiscal_years = response.fiscal_years;
                $scope.hotels = response.hotels;
                // $scope.income_statement.hotel_id = response.current_user_hotel_id;
                $scope.is_admin = response.is_admin;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    // $scope.getFiscalYears = function() {
    //     $scope.ajaxGet('getFiscalYears', {}, true)
    //         .then(function(response) {
    //             // console.log(response);
    //             $scope.fiscal_years = response.fiscalyears;
    //             $scope.hotels = response.hotels;
    //             $scope.income_statement.hotel_id = response.current_user_hotel_id;
    //             $scope.is_admin = response.is_admin;
    //             // $scope.income_statement.fiscal_year = response.fiscal_year;

    //         })
    //         .catch(function(e) {
    //             console.log(e);
    //         })
    // }

    $scope.hideZeroValue = function(val){
        console.log(val);
        if(val == 1){
            $scope.income_statements = $scope.income_statements.filter((is) => is.Total != 0);
        }
        else{
            $scope.incomeStatement();
        }
    }

    $scope.incomeStatement = function() {

        $scope.incomeStatementForm.$submitted = true;
        if (!$scope.incomeStatementForm.$valid) {
            return;
        }

        if ($scope.income_statement.start_date)
            $scope.income_statement.start_date = moment($scope.income_statement.start_date).format("YYYY-MM-DD");
        if ($scope.income_statement.end_date)
            $scope.income_statement.end_date = moment($scope.income_statement.end_date).format("YYYY-MM-DD");


        $scope.ajaxPost('get_income_statement', {
                level: $scope.income_statement.level_no,
                start_date: $scope.income_statement.start_date,
                end_date: $scope.income_statement.end_date,
                fiscal_year: $scope.income_statement.fiscal_year,
                hotel_id: $scope.income_statement.hotel_id,
                

            }, true).then(function(response) {
                if (response.success) {
                    $scope.income_statements = response.income_statements;
                    $scope.zero_records = 0;
                } else {
                    if (response.message)
                        toastr.error(response.message);
                    else
                        toastr.error('Something went wrong');
                }
            })
            .catch(function(e) {
                console.log(e)
            })
    }

    $scope.getLevel = function(lvl, order) {
        switch (lvl) {
            case 1:
                if (order == 0)
                    return 'pl-0';
                else
                    return 'pl-1';
            case 2:
                return 'pl-2';
            case 3:
                return 'pl-3';
            case 4:
                return 'pl-4';
            case 5:
                return 'pl-5';
        }
    }

    $scope.download_pdf = function() {
        if ($scope.income_statement.start_date)
            $scope.income_statement.start_date = moment($scope.income_statement.start_date).format("YYYY-MM-DD");
        if ($scope.income_statement.end_date)
            $scope.income_statement.end_date = moment($scope.income_statement.end_date).format("YYYY-MM-DD");

        $scope.income_statement.account_gl_ids = [...new Set($scope.income_statement.selected_ids)];

        $scope.ajaxPost('income_pdf', {
                level: $scope.income_statement.level_no,
                start_date: $scope.income_statement.start_date,
                end_date: $scope.income_statement.end_date,
                fiscal_year: $scope.income_statement.fiscal_year,
                hotel_id: $scope.income_statement.hotel_id

            }, true).then(function(response) {
                console.log(response);
                if (!response.errors)
                    window.open('pdf/' + response.filename);
                // $scope.general_income_statements = response.account_gls;
            })
            .catch(function(e) {
                console.log(e)
            })
    }

});
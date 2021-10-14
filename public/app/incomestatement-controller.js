app.controller('incomeStatementCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.ledger = {};
    // $scope.account_heads = {};
    $scope.formType = "";
    $scope.errors = [];

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
        $scope.getFiscalYears();
    }

    $scope.getFiscalYears = function() {
        $scope.ajaxGet('getFiscalYears', {}, true)
            .then(function(response) {
                // console.log(response);
                $scope.fiscal_years = response.fiscalyears;
                $scope.hotels = response.hotels;
                $scope.income_statement.hotel_id = response.current_user_hotel_id;
                $scope.is_admin = response.is_admin;
                // $scope.income_statement.fiscal_year = response.fiscal_year;

            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.income_statement = function() {

        $scope.incomeStatementForm.$submitted = true;
        if (!$scope.incomeStatementForm.$valid) {
            return;
        }

        if ($scope.income_statement.start_date)
            $scope.income_statement.start_date = moment($scope.income_statement.start_date).format("YYYY-MM-DD");
        if ($scope.income_statement.end_date)
            $scope.income_statement.end_date = moment($scope.income_statement.end_date).format("YYYY-MM-DD");


        $scope.ajaxPost('get_income_statement', {
                start_date: $scope.income_statement.start_date,
                end_date: $scope.income_statement.end_date,
                fiscal_year: $scope.income_statement.fiscal_year,
                hotel_id: $scope.income_statement.hotel_id,

            }, true).then(function(response) {
                console.log(response.income_statements);
                $scope.income_statements = response.income_statements;
            })
            .catch(function(e) {
                console.log(e)
            })
    }

    $scope.getLevel = function(lvl) {
        switch (lvl) {
            // case 2:
            //     return 'pl-2';
            case 3:
                return 'pl-1';
            case 4:
                return 'pl-3';
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
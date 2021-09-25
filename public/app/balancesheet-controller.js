app.controller('balanceSheetCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.balance_sheets = [];
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
                $scope.balance_sheet.hotel_id = response.current_user_hotel_id;
                $scope.is_admin = response.is_admin;
                // $scope.income_statement.fiscal_year = response.fiscal_year;

            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.balance_sheet = function() {

        $scope.balanceSheetForm.$submitted = true;
        if (!$scope.balanceSheetForm.$valid) {
            return;
        }

        if ($scope.balance_sheet.start_date)
            $scope.balance_sheet.start_date = moment($scope.balance_sheet.start_date).format("YYYY-MM-DD");
        if ($scope.balance_sheet.end_date)
            $scope.balance_sheet.end_date = moment($scope.balance_sheet.end_date).format("YYYY-MM-DD");


        $scope.ajaxPost('get_balance_sheet', {
                start_date: $scope.balance_sheet.start_date,
                end_date: $scope.balance_sheet.end_date,
                fiscal_year: $scope.balance_sheet.fiscal_year,
                hotel_id: $scope.balance_sheet.hotel_id,

            }, true).then(function(response) {
                console.log(response.balance_sheets);
                $scope.balance_sheets = response.balance_sheets;
                $scope.total_equity = response.total_equity;
            })
            .catch(function(e) {
                console.log(e)
            })
    }
    $scope.getLevel = function(lvl) {
        switch (lvl) {
            case 2:
                return 'pl-0';
            case 3:
                return 'pl-20';
            case 4:
                return 'pl-40';
            case 5:
                return 'pl-60';
        }
    }

    $scope.download_pdf = function() {
        if ($scope.balance_sheet.start_date)
            $scope.balance_sheet.start_date = moment($scope.balance_sheet.start_date).format("YYYY-MM-DD");
        if ($scope.balance_sheet.end_date)
            $scope.balance_sheet.end_date = moment($scope.balance_sheet.end_date).format("YYYY-MM-DD");

        $scope.balance_sheet.account_gl_ids = [...new Set($scope.balance_sheet.selected_ids)];

        $scope.ajaxPost('balance_sheet_pdf', {
                start_date: $scope.balance_sheet.start_date,
                end_date: $scope.balance_sheet.end_date,
                fiscal_year: $scope.balance_sheet.fiscal_year,
                hotel_id: $scope.balance_sheet.hotel_id

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
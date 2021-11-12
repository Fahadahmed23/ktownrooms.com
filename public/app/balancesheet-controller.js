app.controller('balanceSheetCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.balance_sheets = [];
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
    $scope.selectAllHotels = function(){
        for (let i = 0; i < $scope.hotels.length; i++) {
            $scope.balance_sheet.hotel_id.push($scope.hotels[i].id);
        }
    }

    $scope.getLevels_FiscalYear = function() {
        $scope.ajaxGet('levels_fiscalyears', {}, true)
            .then(function(response) {
                $scope.levels = response.levels;
                $scope.fiscal_years = response.fiscal_years;
                $scope.hotels = response.hotels;
                // $scope.balance_sheet.hotel_id = response.current_user_hotel_id;
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
    //             $scope.balance_sheet.hotel_id = response.current_user_hotel_id;
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
            $scope.balance_sheets = $scope.balance_sheets.filter((bs) => bs.Total != 0);
        }
        else{
            $scope.balanceSheet();
        }
    }
    $scope.balanceSheet = function() {
        
        $scope.balanceSheetForm.$submitted = true;
        if (!$scope.balanceSheetForm.$valid) {
            return;
        }

        if ($scope.balance_sheet.start_date)
            $scope.balance_sheet.start_date = moment($scope.balance_sheet.start_date).format("YYYY-MM-DD");
        if ($scope.balance_sheet.end_date)
            $scope.balance_sheet.end_date = moment($scope.balance_sheet.end_date).format("YYYY-MM-DD");


        $scope.ajaxPost('get_balance_sheet', {
                level: $scope.income_statement.level_no,
                start_date: $scope.balance_sheet.start_date,
                end_date: $scope.balance_sheet.end_date,
                fiscal_year: $scope.balance_sheet.fiscal_year,
                hotel_id: $scope.balance_sheet.hotel_id,

            }, true).then(function(response) {
                console.log(response.balance_sheets);
                $scope.balance_sheets = response.balance_sheets;
                $scope.total_equity = response.total_equity;
                $scope.zero_records = 0;
                
            })
            .catch(function(e) {
                console.log(e)
            })
            
    }
    $scope.getLevel = function(lvl, order) {
        switch (lvl) {
            case 1:
                return 'pl-0';
            case 2:
                if (order == 2)
                    return 'pl-lg-2';
                else
                    return 'pl-lg-1';
                // return 'pl-2';
            case 3:
                return 'pl-lg-3';
            case 4:
                return 'pl-lg-4';
            case 5:
                return 'pl-lg-5';
        }
        // switch (lvl) {
        //     case 2:
        //         return 'pl-0';
        //     case 3:
        //         return 'pl-20';
        //     case 4:
        //         return 'pl-40';
        //     case 5:
        //         return 'pl-60';
        // }
    }

    $scope.download_pdf = function() {
        if ($scope.balance_sheet.start_date)
            $scope.balance_sheet.start_date = moment($scope.balance_sheet.start_date).format("YYYY-MM-DD");
        if ($scope.balance_sheet.end_date)
            $scope.balance_sheet.end_date = moment($scope.balance_sheet.end_date).format("YYYY-MM-DD");

        $scope.balance_sheet.account_gl_ids = [...new Set($scope.balance_sheet.selected_ids)];

        $scope.ajaxPost('balance_sheet_pdf', {
                level: $scope.income_statement.level_no,
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
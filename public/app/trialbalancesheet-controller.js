app.controller('trialbalancesheetCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.trial_balance = {};
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
        $scope.getLevels_FiscalYear();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getLevels_FiscalYear = function() {
        $scope.ajaxGet('levels_fiscalyears', {}, true)
            .then(function(response) {
                $scope.levels = response.levels;
                $scope.fiscal_years = response.fiscal_years;
                $scope.hotels = response.hotels;
                $scope.trial_balance.hotel_id = response.current_user_hotel_id;
                $scope.is_admin = response.is_admin;
            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.selectAllHotels = function(){
        for (let i = 0; i < $scope.hotels.length; i++) {
            $scope.trial_balance.hotel_id.push($scope.hotels[i].id);
        }
    }
    $scope.hideZeroValue = function(val){
        console.log(val);
        if(val == 1){
            $scope.account_heads = $scope.account_heads.filter((bs) => bs.Credit != 0 || bs.Debit != 0);
        }
        else{
            $scope.TrialBalanceSheet();
        }
    }

    $scope.TrialBalanceSheet = function() {

        $scope.trailBalanceForm.$submitted = true;
        if (!$scope.trailBalanceForm.$valid) {
            return;
        }
        if ($scope.trial_balance.start_date && $scope.trial_balance.end_date) {
            $scope.trial_balance.start_date = moment($scope.trial_balance.start_date).format("YYYY-MM-DD");
            $scope.trial_balance.end_date = moment($scope.trial_balance.end_date).format("YYYY-MM-DD");

        }

        // console.log($scope.trial_balance.end_date);
        // return;

        $scope.ajaxPost('trial_balance_sheet', {
                level: $scope.trial_balance.level_no,
                fiscal_year: $scope.trial_balance.fiscal_year,
                start_date: $scope.trial_balance.start_date,
                end_date: $scope.trial_balance.end_date,
                hotel_id: $scope.trial_balance.hotel_id,

            }, true).then(function(response) {
                console.log(response);
                $scope.account_heads = response.account_heads;
                $scope.totalDebit = 0;
                $scope.totalCredit = 0;
                for (let i = 0; i < $scope.account_heads.length; i++) {
                    $scope.totalDebit += $scope.account_heads[i].Debit;
                    $scope.totalCredit += $scope.account_heads[i].Credit;
                }
                $('.total_credit_debit').show();

                if ($scope.trial_balance.start_date && $scope.trial_balance.end_date) {
                    $scope.trial_balance.start_date = moment($scope.trial_balance.start_date).format('MM/DD/YYYY');
                    $scope.trial_balance.end_date = moment($scope.trial_balance.end_date).format('MM/DD/YYYY');
                }
            })
            .catch(function(e) {
                console.log(e)
            })
    }

    $scope.getLevel = function(lvl) {
        switch (lvl) {
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

    $scope.changeStartDate = function() {
        let m = moment($scope.trial_balance.start_date).format('MM/DD/YYYY');
        $('.enddate').pickadate('picker').set('min', m);

        if (moment(m).diff(moment($scope.trial_balance.end_date), 'days') > 0)
            $scope.trial_balance.end_date = m;
    }

    $scope.changeEndDate = function() {
        let m = moment($scope.trial_balance.end_date).format('MM/DD/YYYY');
        $('.startdate').pickadate('picker').set('max', m);

        if (moment($scope.trial_balance.start_date).diff(moment(m)) > 0)
            $scope.trial_balance.start_date = m;
    }


    $scope.download_pdf = function() {
        $scope.ajaxPost('tb_pdfview', {
                level: $scope.trial_balance.level_no,
                fiscal_year: $scope.trial_balance.fiscal_year,
                start_date: $scope.trial_balance.start_date,
                end_date: $scope.trial_balance.end_date,
                hotel_id: $scope.trial_balance.hotel_id

            }, true).then(function(response) {
                console.log(response);
                $scope.account_heads = response.account_heads;
                if (!response.errors)
                    window.open('tb_pdf/' + response.filename);
            })
            .catch(function(e) {
                console.log(e)
            })
    }


});
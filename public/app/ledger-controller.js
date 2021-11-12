app.controller('ledgerCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

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
        $scope.getGeneralLedgers();
    }


    DragAndDrop.init($scope);

    $scope.selectAllGls = function(){
        for (let i = 0; i < $scope.account_gls.length; i++) {
            $scope.ledger.selected_ids.push($scope.account_gls[i].id);
        }
        $scope.keyword = "Deselect All";
        $('.select').css('display', 'none');
        $('.deselect').css('display', 'block');

    }
    $scope.deselectAllGls = function(){
        for (let i = 0; i < $scope.account_gls.length; i++) {
            $scope.ledger.selected_ids = [];
        }
        $scope.keyword = "Select All";
        $('.deselect').css('display', 'none');
        $('.select').css('display', 'block');
    }
    $scope.keyword = 'Select All';
    $scope.checkAccGl = function(){
        if($scope.ledger.selected_ids){
            if($scope.ledger.selected_ids.length == $scope.account_gls.length){
                $scope.keyword = "Deselect All";
                $('.select').css('display', 'none');
                $('.deselect').css('display', 'block');
            } else {
                $scope.keyword = 'Select All';
                $('.deselect').css('display', 'none');
                $('.select').css('display', 'block');
            }
        }
        console.log($scope.ledger.selected_ids);
    }

    $scope.getGeneralLedgers = function() {
        $scope.ajaxGet('getAccountGL', {}, true)
            .then(function(response) {
                $scope.account_gls = response.general_ledgers;
                $scope.ledger.fiscal_year = response.fiscal_year;
                $scope.hotels = response.hotels;
                $scope.ledger.hotel_id = response.current_user_hotel_id;
                $scope.is_admin = response.is_admin;

                console.log($scope.account_gls);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.getTasks = function() {
        $scope.ajaxGet('getTasks', {}, true)
            .then(function(response) {
                $scope.tasks = response.tasks.department.tasks;
                console.log($scope.tasks);
            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.ledger.selected_ids = [];
    $scope.addSelectedColumn = function(column, target, source) {
        column = $.parseJSON(column);

        // if (column.is_active == 'completed') {
        //     $msg = "Once task is marked completed. Status will not be changed";
        //     toastr.error($msg);
        //     $scope.init();
        //     return;
        // }

        if (target == '1') {
            console.log("target to unselected");
            column.is_active = target;
            $scope.ledger.selected_ids.pop(column.id);
            // $scope.statusUpdate(column, target, source);
        }
        if (target == '0') {
            console.log("target to selected");
            column.is_active = parseInt(target);

            if ($scope.ledger.selected_ids.indexOf(column) === -1) {
                $scope.ledger.selected_ids.push(column.id);
            }
            // $scope.statusUpdate(column, target, source);
        }
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }


    $scope.general_ledger = function() {

        $scope.ledgerForm.$submitted = true;
        if (!$scope.ledgerForm.$valid) {
            return;
        }

        if ($scope.ledger.start_date)
            $scope.ledger.start_date = moment($scope.ledger.start_date).format("YYYY-MM-DD");
        if ($scope.ledger.end_date)
            $scope.ledger.end_date = moment($scope.ledger.end_date).format("YYYY-MM-DD");

        $scope.ledger.account_gl_ids = [...new Set($scope.ledger.selected_ids)];

        $scope.ajaxPost('get_ledger', {
                start_date: $scope.ledger.start_date,
                end_date: $scope.ledger.end_date,
                status: $scope.ledger.status,
                account_gl_ids: $scope.ledger.account_gl_ids,
                hotel_id: $scope.ledger.hotel_id,

            }, true).then(function(response) {
                console.log(response.account_gls);
                $scope.general_ledgers = response.account_gls;
            })
            .catch(function(e) {
                console.log(e)
            })
    }


    $scope.download_pdf = function() {
        if ($scope.ledger.start_date)
            $scope.ledger.start_date = moment($scope.ledger.start_date).format("YYYY-MM-DD");
        if ($scope.ledger.end_date)
            $scope.ledger.end_date = moment($scope.ledger.end_date).format("YYYY-MM-DD");

        $scope.ledger.account_gl_ids = [...new Set($scope.ledger.selected_ids)];

        $scope.ajaxPost('pdfview', {
                start_date: $scope.ledger.start_date,
                end_date: $scope.ledger.end_date,
                status: $scope.ledger.status,
                account_gl_ids: $scope.ledger.account_gl_ids,
                hotel_id: $scope.ledger.hotel_id

            }, true).then(function(response) {
                console.log(response);
                if (!response.errors)
                    window.open('pdf/' + response.filename);
                // $scope.general_ledgers = response.account_gls;
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
        let m = moment($scope.ledger.start_date).format('MM/DD/YYYY');
        $('.enddate').pickadate('picker').set('min', m);

        if (moment(m).diff(moment($scope.ledger.end_date), 'days') > 0)
            $scope.ledger.end_date = m;
    }

    $scope.changeEndDate = function() {
        let m = moment($scope.ledger.end_date).format('MM/DD/YYYY');
        $('.startdate').pickadate('picker').set('max', m);

        if (moment($scope.ledger.start_date).diff(moment(m)) > 0)
            $scope.ledger.start_date = m;
    }


});
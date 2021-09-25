app.controller('promotionsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.promotions = [];

    $scope.promotion = {};

    $scope.formType = "";
    $scope.masking_class
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
        $scope.getPromotions();
    }

    $scope.checktodate = function(a) {

        if ($scope.promotion.ValidFrom > a) {
            toastr.error(`To Date should be greater than from Date `);
        }
    }
    $scope.checkfromdate = function(b) {

        if ($scope.promotion.ValidTo < b) {
            toastr.error(`From Date should be less than to Date `);
        }
    }

    $scope.applypercent = function(p) {
        if (p == 1) {
            console.log(p);
            $(".percentInput").show();
            $(".discountValInput").hide();
        } else {
            $(".discountValInput").show();
            $(".percentInput").hide();
        }
    }








    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getPromotions = function() {
        $scope.ajaxGet('getPromotions', {}, true)
            .then(function(response) {
                $scope.promotions = response;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.editPromotion = function(c) {
        $scope.promotionForm.$setPristine();
        $scope.promotionForm.$setUntouched();
        window.scrollTop();
        $scope.promotion = angular.copy(c);
        $scope.formType = "update";

        $('#addNewPromotion').show('slow');
        $('#searchPromotion').hide();
    }

    $scope.createPromotion = function() {
        $scope.promotionForm.$setPristine();
        $scope.promotionForm.$setUntouched();
        $scope.promotion = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewPromotion').show('slow');
        $('#searchPromotion').hide();
    }

    $scope.modalClose = function() {
        $('.card-body').hide('slow');
    }

    $scope.savePromotion = function() {
        $scope.promotionForm.$submitted = true;
        if (!$scope.promotionForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'promotions' : 'promotions/' + $scope.promotion.id;

        $scope.ajaxPost(formUrl, $scope.promotion, false)
            .then(function(response) {
                if ($scope.formType == "save") {
                    $scope.promotions.push(response.promotion);
                } else {
                    $scope.promotions = $scope.promotions.map((promotion) => promotion.id == $scope.promotion.id ? $scope.promotion : promotion)
                }

                // $scope.promotion = {};
                if (response.success) {
                    $scope.promotion = {};
                    $('#addNewPromotion').hide('slow');
                    $scope.getPromotions();
                }

            })
            .catch(function(e) {
                console.log(response);
            });
    }


    $scope.deletePromotion = function(c) {
        $scope.promotion = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.PromoName + "'?",
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
                    $scope.ajaxPost('promotions/del', { id: $scope.promotion.id }, false)
                        .then(function(response) {
                            $scope.promotions = $scope.promotions.filter((promotions) => promotions.id != response.id);
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewPromotion').hide('slow');
    }
});
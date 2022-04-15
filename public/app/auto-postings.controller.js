app.controller('autopostingsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder, $http) {

    // variables
    $scope.auto_postings = [];
    $scope.posting_type = {};
    $scope.auto_postings_arr = [];
    $scope.auto_posting_ar = {}
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
        $scope.getAutoPostings();
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getAutoPostings = function() {
        $scope.ajaxGet('get_auto_postings', {}, true)
            .then(function(response) {
                $scope.auto_postings = response.auto_postings;

                // for drop downs
                $scope.account_types = response.account_types;
                $scope.account_heads = response.account_heads;
                $scope.auto_posting_types = response.auto_posting_types;
                console.log($scope.auto_postings);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.createAutoPosting = function() {
        window.scrollTop();
        $scope.autoPostingForm.$setPristine();
        $scope.autoPostingForm.$setUntouched();
        $scope.posting_type = {};
        $scope.auto_postings_ar = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewAutoPosting').show('slow');
    }
    $scope.getGl = function(gl_id) {
        console.log(gl_id);
        $scope.gl = angular.copy(Object.values($scope.account_heads).find(ah => ah.id == gl_id))
        $scope.auto_posting_ar.account_gl_name = $scope.gl.title;
        $scope.auto_posting_ar.account_gl_code = $scope.gl.account_gl_code;
        $scope.auto_posting_ar.account_level = $scope.gl.account_level_id;
    }


    $scope.pushAutoPosting = function(auto_posting_ar) {
        console.log(auto_posting_ar);
        $scope.auto_posting_ar.account_type_name = $scope.account_types.find((at) => at.id === auto_posting_ar.account_type_id).title;
        $scope.auto_postings_arr.push(auto_posting_ar);
        $scope.auto_posting_ar = {};
    }
    $scope.removeRecord = function(i, ap) {
        console.log($scope.auto_postings_arr[i]);
        $scope.auto_postings_arr.splice(i, 1);
    }

    $scope.saveAutoPosting = function() {

        $scope.autoPostingForm.$submitted = true;
        if (!$scope.autoPostingForm.$valid) {
            return;
        }

        let formUrl = $scope.formType == "save" ? 'auto_postings' : 'auto_postings/' + $scope.posting_type.auto_posting_type_id;
        $scope.ajaxPost(formUrl, {
                auto_postings_arr: $scope.auto_postings_arr,
                posting_type: $scope.posting_type,
            }, false)
            .then(function(response) {
                if (response.success) {
                    $scope.auto_posting_ar = {};
                    $scope.posting_type = {};
                    $scope.getAutoPostings();
                    $('#addNewAutoPosting').hide('slow');
                }

            })
            .catch(function(e) {
                console.log(response);
            });
    }


    $scope.editAutoPosting = function(ap) {
        $scope.auto_posting_type_id = angular.copy(ap.auto_posting_type_id);
        window.scrollTop();
        $scope.autoPostingForm.$setPristine();
        $scope.autoPostingForm.$setUntouched();

        let formUrl = 'auto_posting_by_type';
        $scope.ajaxPost(formUrl, {
                auto_posting_type_id: $scope.auto_posting_type_id,
            }, true)
            .then(function(response) {
                if (response.success) {
                    $scope.auto_postings_arr = response.ap;
                    $scope.posting_type.auto_posting_type_id = response.ap[0].auto_posting_type_id;
                    $scope.formType = "update";
                    console.log($scope.auto_postings_arr);
                    $('#addNewAutoPosting').show('slow');
                } else {
                    console.log(response);
                }

            })
            .catch(function(e) {
                console.log(response);
            });



        // $scope.auto_postings_arr = $scope.auto_postings.filter((p) => p.auto_posting_type_id == ap.auto_posting_type_id);
        // $scope.posting_type.auto_posting_type_id = ap.auto_posting_type_id;
        // $scope.auto_posting_arr = {};
        // $scope.formType = "update";
        // console.log($scope.auto_postings_arr);
        // $('#addNewAutoPosting').show('slow');

    }
    $scope.revert = function() {
        $('#addNewAutoPosting').hide('slow');
    }

    $scope.deleteAutoPosting = function(ap) {
        $scope.auto_posting = angular.copy(ap);
        console.log($scope.auto_posting);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete?",
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
                    $scope.ajaxPost('auto_postings/del', { id: $scope.auto_posting.id }, false)
                        .then(function(response) {
                            $scope.getAutoPostings();
                            window.scrollTop();
                            $('#addNewAutoPosting').hide('slow');
                        })
                        .catch(function(e) {
                            toastr.error(e);
                        })
                }
            }
        });
    }





});
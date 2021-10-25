app.controller('relationsCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.relations = [];

    $scope.relation={};

    $scope.formType = "";

    $scope.filterSearchText = "";

    //$scope.errors = [];

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
    .withDOM("<'row'<'col-sm-12'tr>>"+
    "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
    .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([2]).notSortable()
    ];

    // functions
    $scope.init = function() {

        $scope.getRelations();
    }

    $scope.getRelations = function() {
        $scope.ajaxGet('getRelations', {
            }, true)
            .then(function(response) {
                $scope.relations = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.editRelation = function (c){
        $scope.relation=angular.copy(c);
        $scope.formType = "update";

        $('#addNewRelation').show('slow');
        $('#searchRelation').hide();
    }


    $scope.createRelation = function () {
        $scope.relation = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewRelation').show('slow');
        $('#searchRelation').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveRelation = function() {
        let formUrl = $scope.formType == "save" ? 'relations' : 'relations/' + $scope.relation.id;
        
        $scope.ajaxPost(formUrl, $scope.relation, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.relations.push(response.relation);
                } else {
                    $scope.relations = $scope.relations.map((relation) => relation.id == $scope.relation.id ? $scope.relation : relation)
                }
                
                $scope.relation = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteRelation = function(c) {
        $scope.relation = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.Relation + "'?",
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
                    $scope.ajaxPost('relations/del', {id: $scope.relation.id}, false)
                    .then(function(response) {
                        $scope.relations = $scope.relations.filter((relation)=>relation.id != response.id);
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewRelation').hide('slow');
    }
});
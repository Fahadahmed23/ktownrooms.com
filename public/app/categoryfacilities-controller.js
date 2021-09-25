app.controller('categoryfacilitiesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder){
    // variables
    $scope.categoryfacilities = [];

    $scope.categoryfacility={};

    $scope.roomcategories = [];

    $scope.roomcategory={};

    $scope.facility= {};

    $scope.facilities = [];

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

        $scope.getCategoryFacilities();
        $scope.getRoomCategories();
        $scope.getFacilities();
    }

    $scope.getCategoryFacilities = function() {
        $scope.ajaxGet('getCategoryFacilities', {
            }, true)
            .then(function(response) {
                $scope.categoryfacilities = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.getRoomCategories = function() {
        $scope.ajaxGet('getRoomCategories', {
            }, true)
            .then(function(response) {
                $scope.roomcategories = response;
            })
            .catch(function(e){
                console.log(e);
            })
    }

    $scope.getFacilities = function() {
        $scope.ajaxGet('getFacilities', {
            }, true)
            .then(function(response) {
                $scope.facilities = response;
            })
            .catch(function(e){
                console.log(e);
            })

            
    }

    $scope.editCategoryFacility = function (c){
        
        $scope.categoryfacility=angular.copy(c);
        $scope.formType = "update";
                    
        
        //drop down work
        $scope.ajaxGet('getDropDownfacilities', {roomcategory_id: c.roomcategory_id}, true)
            .then(function(response) {
                
                var totalFacitlies = $('#facility_id').children('option').length;
                var responseFacilities = response.length;
                $('.multiselect-selected-text').text('');               
                for(var i=0; i<response.length; i++)
                {
                  $(":checkbox[value="+response[i]["facility_id"]+"]").closest('.multiselect-item.dropdown-item').addClass('active');
                  $(":checkbox[value="+response[i]["facility_id"]+"]").prop('checked',true);
                  $('.multiselect').prop('title', $(":checkbox[value="+response[i]["facility_id"]+"]").parent().text());
                  
                  if(i==0)
                  $('.multiselect-selected-text').append($(":checkbox[value="+response[i]["facility_id"]+"]").parent().text());
                  else
                  $('.multiselect-selected-text').append(","+$(":checkbox[value="+response[i]["facility_id"]+"]").parent().text());               
                }

                if(totalFacitlies == responseFacilities )
                   {
                    $('.multiselect-selected-text').text('');
                    $('.multiselect-selected-text').append("All selected ("+totalFacitlies+")");

                   }
                
            })
            .catch(function(e){
                console.log(e);
            })

        // end drop down work
  

        $('#addNewCategoryFacility').show('slow');
        $('#searchCategoryFacility').hide();
    }


    $scope.createCategoryFacility = function () {
        $scope.categoryfacility = {};
        $scope.formType = "save";
        window.scrollTop();
        $('#addNewCategoryFacility').show('slow');
        $('#searchCategoryFacility').hide();
    }

    $scope.modalClose = function(){
        $('.card-body').hide('slow');
    }

    $scope.saveCategoryFacility = function() {
        let formUrl = $scope.formType == "save" ? 'categoryfacilities' : 'categoryfacilities/' + $scope.categoryfacility.id;
        
        $scope.ajaxPost(formUrl, $scope.categoryfacility, false)
            .then(function(response){
                if ($scope.formType == "save") {
                    $scope.categoryfacilities.push(response.categoryfacility);
                } else {
                    $scope.categoryfacilities = $scope.categoryfacilities.map((categoryfacility) => categoryfacility.id == $scope.categoryfacility.id ? $scope.categoryfacility : categoryfacility)
                }
                
                $scope.categoryfacility = {};
            })
            .catch(function(e){
                console.log(response);
            });
    }

    $scope.deleteCategoryFacility = function(c) {
        $scope.categoryfacility = angular.copy(c);
        bootbox.confirm({
            title: 'Confirm Deletion',
            message: "Are you sure you want to delete '" + c.categoryfacility_id + "'?",
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
                    $scope.ajaxPost('categoryfacilities/del', {id: $scope.categoryfacility.id}, false)
                    .then(function(response) {
                        $scope.categoryfacilities = $scope.categoryfacilities.filter((categoryfacility)=>categoryfacility.id != response.id);
                       
                       //drop down work
                        $scope.ajaxGet('getDropDownfacilities', {roomcategory_id: c.roomcategory_id}, true)
                        .then(function(response) {
                            
                            var totalFacitlies = $('#facility_id').children('option').length;
                            var responseFacilities = response.length;
                            $('.multiselect-selected-text').text('');               
                            for(var i=0; i<response.length; i++)
                            {
                              $(":checkbox[value="+response[i]["facility_id"]+"]").closest('.multiselect-item.dropdown-item').addClass('active');
                              $(":checkbox[value="+response[i]["facility_id"]+"]").prop('checked',true);
                              $('.multiselect').prop('title', $(":checkbox[value="+response[i]["facility_id"]+"]").parent().text());
                              
                              if(i==0)
                              $('.multiselect-selected-text').append($(":checkbox[value="+response[i]["facility_id"]+"]").parent().text());
                              else
                              $('.multiselect-selected-text').append(","+$(":checkbox[value="+response[i]["facility_id"]+"]").parent().text());               
                            }
            
                            if(totalFacitlies == responseFacilities )
                               {
                                $('.multiselect-selected-text').text('');
                                $('.multiselect-selected-text').append("All selected ("+totalFacitlies+")");
            
                               }
                            
                        })
                        .catch(function(e){
                            console.log(e);
                        })

                        //---end drop down work
            
                    })
                    .catch(function(e) {
                        toastr.error(e);
                    })
                }
            }
        });
    }

    $scope.revert = function() {
        $('#addNewCategoryFacility').hide('slow');
    }
});
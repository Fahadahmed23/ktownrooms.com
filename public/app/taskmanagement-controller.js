app.controller('taskmanagementCtrl', function($scope) {

    //scope variables

    $scope.tasks = [];
    $scope.filter = {};
    $scope.date_filter = {};

    // scope functions

    $scope.getpriority = function(p) {
        switch (p) {
            case 'Low':
                return 'badge-info';
            case 'Normal':
                return 'badge-warning';
            case 'High':
                return 'badge-danger';

        }
    }

    $scope.showFilter = function() {
        $('.sidebar').toggle();
    }

    $scope.hideFilter = function() {
        $('.sidebar').hide();
    }

    $scope.getTaskStatus = function(s) {
        switch (s) {
            case 'todo':
                return 'bg-info';
            case 'inprogress':
                return 'bg-warning';
            case 'completed':
                return 'bg-success';
        }
    }

    $scope.init = function() {
        console.log("initialize");
        $scope.getddData();
        $scope.getTasks();
        $scope.date_filter = 'today';


    }
    DragAndDrop.init($scope);

    $scope.getFilterTasks = function(did) {
        $scope.department = angular.copy(Object.values($scope.departments).find(d => d.id == did));
        $scope.department_name = $scope.department.Department;
        $scope.getTasks();
    }

    $scope.filterByDate = function(d) {
        $scope.date_filter = d;
        $scope.getTasks();

    }

    $scope.filterData = function(searchFields, check) {
        if (check == 'clear') {
            $scope.filters = {};
            $scope.date_filter = 'today';
        } else {
            $scope.filters = angular.copy(searchFields);
        }
        $scope.getTasks($scope.filters);
    }

    $scope.getTasks = function() {
        $scope.ajaxPost('getTasks', {
                date: $scope.date_filter,
                filters: $scope.filters,
            }, true)
            .then(function(response) {
                //$scope.tasks = response.tasks;
                $scope.tasks = response?.tasks?.map(t => {
                    return {
                        ...t,
                        isSelected: false,
                        cssClass: 'md-amber'
                    }
                });
                
                $scope.counts = response.counts;
                $scope.user_is_admin = response.user_is_admin;
                $scope.isSelectHotel = response.isSelectHotel;
                $scope.isSelectDepartment = response.isSelectDepartment;
                console.log($scope.tasks);
                for (let i = 0; i < $scope.tasks.length; i++) {
                    $scope.tasks[i].booking_service.created_at = moment($scope.tasks[i].created_at).format('MM/DD/YYYY');
                }

                setTimeout(function() { $('[data-popup="popover"]').popover(); }, 500);
            })
            .catch(function(e) {
                console.log(e);
            })
    }
    $scope.getddData = function() {
        $scope.ajaxGet('get_dropdowns', {}, true)
            .then(function(response) {
                $scope.departments = response.departments;
                $scope.hotels = response.hotels;
                // $scope.rooms = response.rooms;
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.addSelectedColumn = function(column, target, source) {
        column = $.parseJSON(column);

        if (column.status == 'completed') {
            $msg = "Once task is marked completed. Status will not be changed";
            toastr.error($msg);
            $scope.init();
            return;
        }

        if (target == 'inprogress') {
            console.log("target to inprogress");
            $scope.statusUpdate(column, target, source);
        }
        if (target == 'completed') {
            console.log("target to completed");
            $scope.statusUpdate(column, target, source);
        }
        if (target == 'todo') {
            console.log("target to todo");
            $scope.statusUpdate(column, target, source);
        }
    }

    $scope.statusUpdate = function(column, target, source) {
        $scope.ajaxPost('task/updateStatus', {
            task: column,
            source_status: column.status,
            target_status: target
        }, false).then(function(response) {
            
            if (response.success) {
                $scope.getTasks();
            }
        }).catch(function(e) {
            console.log(e);
        })
    }
    
    //$scope.data = {
    //    isSelected: false,
    //    cssClass: 'md-amber'
    //};

    $scope.statusUpdatebtc = function(e,column) {
         
        if(e==false){
            $scope.isSelected =1;

        }
        else if(e==true){
            $scope.isSelected =0;

        }
        
        console.log('Column');
        console.log(column);
        console.log('Selected  Status');
        console.log($scope.isSelected);
        
        //alert($scope.isSelected);


        
        $scope.ajaxPost('task/updateStatusBtc', {
            
            task: column,
            is_btc : $scope.isSelected

        }, false).then(function(response) {
            
            //console.log('Update Status Btc');
            console.log(response);
            //if (response.success) {
                //$scope.getTasks();
            //}
        }).catch(function(e) {
            console.log(e);
        })
        
    
    }

});
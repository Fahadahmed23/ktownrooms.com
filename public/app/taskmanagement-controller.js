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
        $scope.getDepartments();
        $scope.getTasks();


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
    $scope.getTasks = function() {
        $scope.ajaxPost('getTasks', {
                department_id: $scope.filter.department_id,
                date: $scope.date_filter
            }, true)
            .then(function(response) {
                $scope.tasks = response.tasks;
                $scope.counts = response.counts;
                $scope.user_is_admin = response.user_is_admin;
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
    $scope.getDepartments = function() {
        $scope.ajaxGet('get_departments', {}, true)
            .then(function(response) {
                $scope.departments = response.departments;
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

});
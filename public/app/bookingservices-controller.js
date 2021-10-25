app.controller('bookingservicesCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {

    //scope variables
    $scope.bookingservices = {};
    $scope.task = {};

    $scope.selected_date = "";

    // datatables
    $scope.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers')
        .withDOM("<'row'<'col-sm-12'tr>>" +
            "<'row p-2 '<'col-sm-5'i><'col-sm-7'p>>")
        .withOption('stateSave', true);
    $scope.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef([3, 4]).notSortable()
    ];

    $scope.init = function() {

        // use timeout because calender date is not set and ajax get is hiiting before it
        setTimeout(function() {
            $scope.selected_date = $(".middleDay").attr('data-celldate');
            $scope.getHotelRooms();
        }, 3000);




    }
    $scope.getHotelRooms = function() {
        $scope.ajaxGet('getHotelRooms', {
                selected_date: $scope.selected_date
            }, true).then(function(response) {
                $scope.hotelrooms = response.hotelrooms;
                $scope.rooms = $scope.hotelrooms.hotel.rooms;
                console.log($scope.rooms);
            })
            .catch(function(e) {
                console.log(e);
            })
    }

    $scope.assignTask = function(room) {
        $scope.taskForm.$setPristine();
        $scope.taskForm.$setUntouched();

        $scope.assigntask = angular.copy(room);
        $('#roomsRecord').removeClass('col-md-12').addClass('col-md-8');
        $("#assignTaskForm").show('slow');
        $("#taskDetail").hide();

        $scope.task = {
            room_id: $scope.assigntask.id,
        }
    }

    $scope.hideassignTask = function() {
        $("#roomsRecord").addClass('col-md-12').removeClass('col-md-8');
        $("#assignTaskForm").hide();
    }

    $scope.taskDetail = function(task) {

        $scope.taskdetail = angular.copy(task);
        console.log($scope.taskdetail);
        $('#roomsRecord').removeClass('col-md-12').addClass('col-md-8');
        $("#taskDetail").show('show');
        $("#assignTaskForm").hide();
    }
    $scope.hidetaskDetail = function() {
        $("#roomsRecord").addClass('col-md-12').removeClass('col-md-8');
        $("#taskDetail").hide();
    }

    $scope.saveTask = function() {
        $scope.taskForm.$submitted = true;
        if (!$scope.taskForm.$valid) {
            return;
        }
        $scope.service = $scope.assigntask.services.filter((s) => s.id == $scope.task.service_id);
        $scope.task.department_id = $scope.service[0].department.id;
        console.log($scope.task);

        $scope.ajaxPost('saveTask', {
                task: $scope.task
            }, false)
            .then(function(response) {
                if (response.success) {

                    $scope.init();
                    $scope.task = {};
                    $scope.hideassignTask();
                }
            }).catch(function(e) {
                console.log(response);
            })
    }

    $scope.getTaskStatus = function(s) {
        switch (s) {
            case 'todo':
                return 'badge-info';
            case 'inprogress':
                return 'badge-warning';
            case 'completed':
                return 'badge-success';

        }
    }

});
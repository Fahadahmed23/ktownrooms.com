
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Booking Services Management</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>
    </div>

    <div class="card">
            <div class="rescalendar" id="my_calendar_simple">
            </div>
    </div>
   
    <div class="">
        <div class="flex">
            <div id="roomsRecord" class="room-record float-left col-md-12 px-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="max-width: 100px;">
                                 <p class="float-left mb-0 pt-2">Room #</p>
                                    <div class="input-group float-right" style="width:50%;">
                                        <input ng-model="searchRoom" type="text" class="form-control" placeholder="Search Room">
                                        <span class="input-group-append">
                                            <span class="input-group-text">
                                                <a href="" class="text-dark"><i class="icon-search4"></i></a>
                                            </span>
                                        </span>
                                    </div>
                            </th>
                            <th>Cleaning</th>
                            <th>Kitchen</th>
                            <th>Laundry</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="room in rooms | filter : {room_title:searchRoom }">
                            <td>[[room.room_title]]</td>
                            <td class="">
                                <div ng-if="room.tasks.length >= 1" class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-minus2"></i></a>
                                        <div class="dropdown-menu p-0">
                                            <span ng-class="getTaskStatus(task.status)" ng-click="taskDetail(task)" ng-repeat="task in room.tasks" class="dropdown-item"><i  class="icon-minus2"></i> [[task.service]]</span>
                                        </div>
                                    </div>
                                </div>
                                <span id="assignTask" ng-click="assignTask(room)" class="float-right add-tasklist"><i class="icon-add-to-list"></i></span>

                            </td>
                            <td class="">
                                <span class="float-right add-tasklist"><i class="icon-add-to-list"></i></span>
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-minus2"></i></a>
                                        <div class="dropdown-menu">
                                            <span class="dropdown-item "><i class="icon-minus2"></i> Tea</span>
                                            <span class="dropdown-item "><i class="icon-minus2"></i> Breakfast</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="">
                                <span class="float-right add-tasklist"><i class="icon-add-to-list"></i></span>
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-minus2"></i></a>
                                        <div class="dropdown-menu">
                                            <span class="dropdown-item "><i class="icon-minus2"></i> Bed Sheet</span>
                                            <span class="dropdown-item "><i class="icon-minus2"></i> Towel</span>
                                            <span class="dropdown-item "><i class="icon-minus2"></i> Blankit</span>
                                            <span class="dropdown-item "><i class="icon-minus2"></i> Napkins</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @include('booking_services/assign-task')
            @include('booking_services/services-info')
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#my_calendar_simple').rescalendar({
            id: 'my_calendar_simple',
            dataKeyField: 'name',
            dataKeyValues: ['item1']
        });
    });
</script>
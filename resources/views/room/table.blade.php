<div id="roomTable" class="table-responsive">
    <table id="room_table"  class="table table-user table-striped hover display datatable-basic" >
        <thead>
            <tr>
                <th><a ng-click="sorting('HotelName')">Hotel
                    <span ng-switch="order_by_column">
                        <span ng-switch-when="HotelName"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="HotelNameMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span>
                    </a>
                </th>
                <th>Room Image</th>
                <th><a ng-click="sorting('RoomTitle')">Room Title
                        <span ng-switch="order_by_column">
                        <span ng-switch-when="RoomTitle"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="RoomTitleMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span>
                    </a></th>
                <th><a ng-click="sorting('RoomType')">Room Type
                        <span ng-switch="order_by_column">
                        <span ng-switch-when="RoomType"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="RoomTypeMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span>
                    </a></th>
                <th><a ng-click="sorting('RoomCategory')">Room Category
                        <span ng-switch="order_by_column">
                        <span ng-switch-when="RoomCategory"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="RoomCategoryMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span></a></th>
                <th><a ng-click="sorting('RoomNumber')">Room Number
                        <span ng-switch="order_by_column">
                        <span ng-switch-when="RoomNumber"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="RoomNumberMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span>
                    </a></th>
                <th><a ng-click="sorting('FloorNo')">Floor No
                        <span ng-switch="order_by_column">
                        <span ng-switch-when="FloorNo"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="FloorNoMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span></a></th>
                <th><a ng-click="sorting('RoomCharges')">Room Charges
                        <span ng-switch="order_by_column">
                        <span ng-switch-when="RoomCharges"><i class="fa fa-angle-down" style="font-size:15px"></i></span>
                        <span ng-switch-when="RoomChargesMinus"><i class="fa fa-angle-up" style="font-size:15px"></i></span>
                        <span ng-switch-default><i class="fas fa-sort" style="font-size:15px"></i></span>
                    </span></a></th>
                <th>Action</th>

{{--                http://127.0.0.1:8000/fetchrooms?PageNo=2&HotelName=GOHO%20Hunza%20Peace%20Point&RoomCategory={%27Budget%20Double%20Room%27,%27Deluxe%20Double%20Room%27,%27Quad%20Room%27,%27Master%20Room%27,%27Deluxe%20Room%27}--}}
{{--                http://127.0.0.1:8000/fetchrooms?PageNo=2&RoomCategory={%27Budget%20Double%20Room%27,%27Deluxe%20Double%20Room%27,%27Quad%20Room%27,%27Master%20Room%27,%27Deluxe%20Room%27}--}}
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr dir-paginate="room in rooms | itemsPerPage: room_per_page" total-items="total_room" current-page="pagination.current">
                <td>[[room.hotel.HotelName]]</td>
                <td><img ng-if="room.thumbnail" width="50px" height="auto" ng-src="[[room.thumbnail]]"></td>
                <td>[[room.room_title]]</td>
                <td>[[room.room_type.RoomType]]</td>
                <td>[[room.category.RoomCategory]]</td>
                <td>[[room.RoomNumber]]</td>
                <td>[[room.FloorNo]]</td>
                <td>[[room.RoomCharges | currency]]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            @permission('can-edit-room')
                            <a id="edit-room" ng-click="editRoom(room)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>
                            @endpermission

                            @permission('can-delete-room')
                            <a id="delete-room" ng-click="deleteRoom(room)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                            @endpermission
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
{{--    <script>--}}
{{--        window.onload = function(){--}}
{{--            var page_numbers;--}}
{{--            fetch('fetchrooms?PageNo=1&results_per_page=1')--}}
{{--                .then((response) => response.json())--}}
{{--                .then((data) => create_pagination(data.total_pages));--}}
{{--            console.log(page_numbers)--}}
{{--            function create_pagination(number_of_page){--}}
{{--                var pagination_html = '';--}}
{{--                for(var i=0;i<number_of_page;i++){--}}
{{--                    pagination_html+='  <button ng-' +--}}
{{--                        '="getnRooms('+(i+1)+')">'+(i+1)+'</button>'--}}
{{--                }--}}
{{--                document.getElementById('pagination').innerHTML = pagination_html--}}

{{--            }--}}


{{--        }--}}
{{--    </script>--}}
{{--    <div id="pagination" class="pagination_section">--}}
{{--        <button ng-click="getnRooms(2)"><< Previous</button>--}}
{{--        <button ng-click="getnRooms(3)" title="Algorithm">1</button>--}}
{{--        <button onclick="console.log(2)" title="DataStructure">2</button>--}}
{{--        <button onclick="console.log(2)" title="Languages">3</button>--}}
{{--        <button onclick="console.log(2)" title="Interview" class="active">4</button>--}}
{{--        <button onclick="console.log(2)" title="practice">5</button>--}}
{{--        <button onclick="getnRooms(2)">Next >></button>--}}
{{--    </div>--}}
</div>
<hr>
<dir-pagination-controls  boundary-links="true" on-page-change="getnRooms(newPageNumber)" ></dir-pagination-controls>

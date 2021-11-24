
<div id="citiesChartSec" class="cities card p-3" style="display: none">
    <!-- City Reports Graph View-->
    <div class=" row ">
        <div  class="col-md-4" ng-repeat="(key, city)  in records.cities ">
                <div class="card" >
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">[[city.CityName]]</h5>
                    </div>
    
                    <div class="card-body">
                        <div class="chart-container text-center ">
                            <div class="d-inline-block google-donut1" id="google-donut[[key]]"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <a href="#" class="hotel-rec-view">
                                    <h5 class="font-weight-semibold mb-0" style="font-size: 15px;">[[city.HotelCount]]</h5>
                                    <span class="text-muted font-size-sm" ng-dblclick="gotoReport()">Hotels</span>
                                </a>
                            </div>
    
                            <div class="col-4">
                                <a href="#">
                                    <h5 class="font-weight-semibold mb-0">[[city.CityRoomCount]]</h5>
                                    <span class="text-muted font-size-sm">Rooms</span>
                                </a>
                            </div>
    
                            {{-- <div class="col-4">
                                <h5 class="font-weight-semibold mb-0" style="font-size: 15px;">3,22,693</h5>
                                <span class="text-muted font-size-sm">Revenue</span>
                            </div> --}}
                        </div>
                    </div>
                </div>            
        </div>
    </div>
</div>


    {{-- <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Reserved Rooms',     80],
            ['Remaining Rooms',      220]
          ]);
  
          var options = {
            fontName: 'Roboto',
            pieHole: 0.55,
            height: 250,
            width: 400,
            chartArea: {
                left: 50,
                width: '90%',
                height: '90%'
            }
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('google-donut1'));
          chart.draw(data, options);
        }    
    </script> --}}
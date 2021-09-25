app.controller('dashboardCtrl', function($scope, DTColumnDefBuilder, DTOptionsBuilder) {
    // variables
    $scope.records = {};
    $scope.room_ids = [];
    //********************************** FUNCTIONS *******************************// 

    $scope.init = function() {
        $scope.getRecords();
    }
    $scope.citiesChartSec = function() {
        $scope.drawCityChart();
        $("#citiesChartSec").show('slow');
        $("#roomsChartSec").hide('slow');
        $("#hotelsChartSec").hide('slow');
        $("#selectcityDD").hide('slow');
        $("#searchFilterSec").hide('slow');
    }
    $scope.roomsChartSec = function() {
        $("#roomsChartSec").show('slow');
        $("#hotelsChartSec").hide('slow');
        $("#citiesChartSec").hide('slow');
        $("#selectcityDD").hide('slow');
        $("#searchFilterSec").hide('slow');
    }
    $scope.hotelsChartSec = function() {
        $scope.drawHotelChart();
        $("#hotelsChartSec").show('slow');
        $("#roomsChartSec").hide('slow');
        $("#citiesChartSec").hide('slow');
        $("#selectcityDD").show('slow');
        $("#searchFilterSec").show('slow');
    }

    $scope.gotoReport = function(graph, period = 'Year', year = new Date().getFullYear(), report_conditions = null) {
        var url = graph.report_url;
        var title = graph.title;
        if (report_conditions) {
            localStorage.setItem("searchGroupsTemp", JSON.stringify(report_conditions));
        }
        if (url) {
            window.open(site_url(url + '&_period_=' + period + '&_year_=' + year + '&title=' + title), '_self');
        }
    }

    $scope.getRecords = function() {
            $scope.ajaxGet('getRecords', {}, true)
                .then(function(response) {
                    $scope.records = response;
                    $scope.is_admin = response.is_admin;
                    $scope.user = response.user;

                    //  city chart
                    console.log($scope.records.cities);
                    google.charts.load("current", { packages: ["corechart"] });
                    google.charts.setOnLoadCallback($scope.drawCityChart);

                    // hotel chart
                    console.log($scope.records.hotels);
                    google.charts.load("current", { packages: ["corechart"] });
                    google.charts.setOnLoadCallback($scope.drawHotelChart);

                    // room chart
                    console.log($scope.records.rooms);
                    google.charts.load('current', { 'packages': ['bar'] });
                    google.charts.setOnLoadCallback($scope.drawRoomChart);

                    // google.charts.load("current", { packages: ["corechart"] });
                    // google.charts.setOnLoadCallback($scope.drawRoomChart);
                })
                .catch(function(e) {
                    console.log(e);
                })
        }
        // city chart
    $scope.drawCityChart = function() {
        for (let i = 0; i < $scope.records.citiesCount; i++) {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Reserved ', 80],
                ['Remaining ', 220]
            ]);

            var options = {
                fontName: 'Roboto',
                pieHole: 0.55,
                chartArea: {
                    left: 50,
                    width: '100%',
                    height: '100%'
                },
                width: 350,
                height: 250,
                // legend: 'none'
            };
            let cityid = 'google-donut' + i;
            // console.log(cityid);
            var chart = new google.visualization.PieChart(document.getElementById(cityid));
            chart.draw(data, options);
        }
    }

    // hotel chart
    $scope.drawHotelChart = function() {
        // console.log($scope.records);
        for (let i = 0; i < $scope.records.hotelsCount; i++) {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Confirmed Booking', $scope.records.hotels[i].ConfirmBookingCount],
                ['Cancelled Booking', $scope.records.hotels[i].CancelBookingCount],
                ['Pending Booking', $scope.records.hotels[i].PendingBookingCount]
            ]);

            var options = {
                fontName: 'Roboto',
                pieHole: 0.55,
                chartArea: {
                    left: 20,
                    width: '100%',
                    height: '100%'
                },
                width: 350,
                height: 250,
                // legend: 'none'
            };
            let hotelid = 'hotel-donut' + i;
            // console.log(hotelid);
            var chart = new google.visualization.PieChart(document.getElementById(hotelid));
            chart.draw(data, options);
        }
    }

    // room chart
    $scope.drawRoomChart = function() {
        let length = $scope.records.rooms.length;
        $scope.room_ids = [];

        for (let i = 0; i < length; i++) {
            let id = $scope.records.rooms[i].room_id;
            let n = [
                ['Months', 'Confirmed', 'Cancelled', 'Pending']
            ];
            n.push(['Jan', 0, 0, 0]);
            n.push(['Feb', 0, 0, 0]);
            n.push(['Mar', 0, 0, 0]);
            n.push(['Apr', 0, 0, 0]);
            n.push(['May', 0, 0, 0]);
            n.push(['Jun', 0, 0, 0]);
            n.push(['Jul', 0, 0, 0]);
            n.push(['Aug', 0, 0, 0]);
            n.push(['Sep', 0, 0, 0]);
            n.push(['Oct', 0, 0, 0]);
            n.push(['Nov', 0, 0, 0]);
            n.push(['Dec', 0, 0, 0]);

            $scope.room_ids.push($scope.records.rooms[i]);
            $scope.$apply();

            let j = i;
            let num_rows = 0;
            while (j < length && id == $scope.records.rooms[j].room_id) {
                n[$scope.records.rooms[j].month_name][1] = $scope.records.rooms[j].confirmed;
                n[$scope.records.rooms[j].month_name][2] = $scope.records.rooms[j].cancelled;
                n[$scope.records.rooms[j].month_name][3] = $scope.records.rooms[j].pending;
                num_rows++;
                j++;
            }
            if (num_rows > 1) {
                i = j - 1;
            }
            var data = google.visualization.arrayToDataTable(n);
            var options = {
                isStacked: true,
                vAxis: { title: 'Booking Counts' },
                hAxis: { title: 'Months' },
                seriesType: 'bars',
                chartArea: {
                    left: 20,
                    top: 30,
                    width: '75%',
                    height: '75%'
                },
                legend: 'bottom',
                width: 550,
                height: 350,
                series: { 5: { type: 'line' } }
            };
            let roomid = 'room-donut' + ($scope.room_ids.length - 1);
            var chart = new google.visualization.ComboChart(document.getElementById(roomid));
            // var chart = new google.charts.Bar(document.getElementById(roomid));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }


    }



    //room chart
    // $scope.drawRoomChart = function() {
    //     for (let i = 0; i < $scope.records.roomsCount; i++) {
    //         var data = google.visualization.arrayToDataTable([
    //             ['Task', 'Hours per Day'],
    //             ['Reserved Rooms', 80],
    //             ['Remaining Rooms', 220]
    //         ]);

    //         var options = {
    //             fontName: 'Roboto',
    //             pieHole: 0.55,
    //             chartArea: {
    //                 left: 50,
    //                 width: '100%',
    //                 height: '100%'
    //             },
    //             width: 350,
    //             height: 250,
    //             legend: 'none'
    //         };
    //         let roomid = 'room-donut' + i;
    //         // console.log(roomid);
    //         var chart = new google.visualization.PieChart(document.getElementById(roomid));
    //         chart.draw(data, options);
    //     }
    // }










});
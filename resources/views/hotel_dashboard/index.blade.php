@extends('layouts.app')

@section('scripts')
<script src="app/hoteldashboard-controller.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.0"></script>
@endsection


@section('content')


<div class="content" ng-controller='hotelDashboardCtrl' ng-init='init()'>
    <div class="m-auto">
        {{-- @include('dashboard.countboxes') --}}
        @include('hotel_dashboard.welcome_message')
        @include('hotel_dashboard.stats')
        @include('hotel_dashboard.charts')
        @include('hotel_dashboard.requests')
        @include('hotel_dashboard.complains')
        @include('hotel_dashboard.calendar')
        {{-- @include('dashboard.filter') --}}

        {{-- @include('hotel_dashboard.charts.cities') --}}
        {{-- @include('hotel_dashboard.charts.hotels') --}}
        {{-- @include('hotel_dashboard.charts.rooms') --}}
        {{-- @include('dashboard.searchfilter') --}}


        {{-- </div> --}}
        <div class="d-md-flex admin-panel-section align-items-md-start">


            <!-- datatable component -->
            <div class="flex-fill">

            </div>
            <!-- /datatable component -->

        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    var myAllBookingChart = null;
    function loadAllBookingsGraph(labels, datasets){
        if(myAllBookingChart!=null){
            myAllBookingChart.destroy();
        }
        const data = {
            labels: labels,
            datasets: datasets
        }
        var ctx = document.getElementById('allBookingChart').getContext('2d');
        myAllBookingChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
    var myPieChart = null;
    function loadChannelBookingsGraph(labels, datasets){
        if(myPieChart!=null){
            myPieChart.destroy();
        }
        const data2 = {
            labels: labels,
            datasets: datasets
        };
        var ctx2 = document.getElementById('channelChart').getContext('2d');
        myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: data2,
            options: {
                responsive: true,
                legend: {
                    position: 'left',
                    labels: {
                        boxWidth: 20,
                        padding: 20
                    }
                }
            }
        });
    }



    function loadBookingStatistics(data, element, size) {
    
        console.log('Arman Ahmad');
        console.log(data.total_checkedins_today);
        console.log(data.total_checkedouts_today);
        // Pie with progress bar
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Initialize chart only if element exsists in the DOM
        if (element) {
            console.log(data);
            // Demo dataset
            var dataset = [
                { name: 'Occupied', count: data.rooms_occupied },
                { name: 'Reserved', count: data.rooms_reserved },
                { name: 'Available', count: data.rooms_available },
                { name: 'Blocked', count: data.rooms_blocked },
                { name: 'CheckedIns Today', count: data.total_checkedins_today },
                { name: 'CheckedOut Today', count: data.total_checkedouts_today },
            ];

            // Main variables
            var d3Container = d3.select(element),
                total = 0,
                width = size,
                height = size,
                progressSpacing = 6,
                progressSize = (progressSpacing + 2),
                arcSize = 20,
                outerRadius = (width / 2),
                innerRadius = (outerRadius - arcSize);

            // Colors
            var color = d3.scale.ordinal()
                .range(['#66BB6A', '#ea883f', '#29b6f6', '#EF5350','#BB8FCE','#1C2833']);


            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append("svg");

            // Add SVG group
            var svg = container
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");


            // Construct chart layout
            // ------------------------------

            // Add dataset
            dataset.forEach(function(d) {
                total += d.count;
            });

            // Pie layout
            var pie = d3.layout.pie()
                .value(function(d) { return d.count; })
                .sort(null);

            // Inner arc
            var arc = d3.svg.arc()
                .innerRadius(innerRadius)
                .outerRadius(outerRadius);

            // Line arc
            var arcLine = d3.svg.arc()
                .innerRadius(innerRadius - progressSize)
                .outerRadius(innerRadius - progressSpacing)
                .startAngle(0);


            // Append chart elements
            // ------------------------------

            //
            // Animations
            //
            var arcTween = function(transition, newAngle) {
                transition.attrTween("d", function(d) {
                    var interpolate = d3.interpolate(d.endAngle, newAngle);
                    var interpolateCount = d3.interpolate(0, (data.rooms_count));
                    return function(t) {
                        d.endAngle = interpolate(t);
                        middleCount.text(d3.format(",d")(Math.floor(interpolateCount(t))));
                        return arcLine(d);
                    };
                });
            };


            //
            // Donut paths
            //

            // Donut
            var path = svg.selectAll('path')
                .data(pie(dataset))
                .enter()
                .append('path')
                .attr('d', arc)
                .attr('fill', function(d, i) {
                    return color(d.data.name);
                })
                .style({
                    'stroke': '#fff',
                    'stroke-width': 2,
                    'cursor': 'pointer'
                });

            // Animate donut
            path
                .transition()
                .delay(function(d, i) { return i; })
                .duration(600)
                .attrTween("d", function(d) {
                    var interpolate = d3.interpolate(d.startAngle, d.endAngle);
                    return function(t) {
                        d.endAngle = interpolate(t);
                        return arc(d);
                    };
                });


            //
            // Line path 
            //

            // Line
            var pathLine = svg.append('path')
                .datum({ endAngle: 0 })
                .attr('d', arcLine)
                .style({
                    fill: color('New')
                });

            // Line animation
            pathLine.transition()
                .duration(600)
                .delay(300)
                .call(arcTween, (2 * Math.PI) * (dataset[0].count / total));


            //
            // Add count text
            //

            var middleCount = svg.append('text')
                .datum(0)
                .attr('dy', 6)
                .style({
                    'font-size': '21px',
                    'font-weight': 500,
                    'text-anchor': 'middle'
                })
                .text(function(d) {
                    return d;
                });


            //
            // Add interactions
            //

            // Mouse
            path
                .on('mouseover', function(d, i) {
                    $(element + ' [data-slice]').css({
                        'opacity': 0.3,
                        'transition': 'all ease-in-out 0.15s'
                    });
                    $(element + ' [data-slice=' + i + ']').css({ 'opacity': 1 });
                })
                .on('mouseout', function(d, i) {
                    $(element + ' [data-slice]').css('opacity', 1);
                });


            //
            // Add legend
            //

            // Append list
            var legend = d3.select(element)
                .append('ul')
                .attr('class', 'chart-widget-legend')
                .selectAll('li')
                .data(pie(dataset))
                .enter()
                .append('li')
                .attr('data-slice', function(d, i) {
                    return i;
                })
                .attr('style', function(d, i) {
                    return 'border-bottom: solid 2px ' + color(d.data.name);
                })
                .text(function(d, i) {
                    return d.data.name + ': ';
                });

            // Append legend text
            legend.append('span')
                .text(function(d, i) {
                    return d.data.count;
                });
        }
    }


    function loadTotalRevenue(data, element, chartHeight, color){
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Initialize chart only if element exsists in the DOM
        if (element) {


            // Basic setup
            // ------------------------------

            // Define main variables
            var d3Container = d3.select(element),
                margin = { top: 0, right: 0, bottom: 0, left: 0 },
                width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                height = chartHeight - margin.top - margin.bottom;

            // Date and time format
            var parseDate = d3.time.format('%Y-%m-%d').parse;


            // Create SVG
            // ------------------------------

            // Container
            var container = d3Container.append('svg');

            // SVG element
            var svg = container
                .attr('width', width + margin.left + margin.right)
                .attr('height', height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


            // Construct chart layout
            // ------------------------------

            // Area
            var area = d3.svg.area()
                .x(function(d) { return x(d.date); })
                .y0(height)
                .y1(function(d) { return y(d.value); })
                .interpolate('monotone');


            // Construct scales
            // ------------------------------

            // Horizontal
            var x = d3.time.scale().range([0, width]);

            // Vertical
            var y = d3.scale.linear().range([height, 0]);


            // Load data
            // ------------------------------

            // d3.json("../../../../global_assets/demo_data/dashboard/monthly_sales.json", function(error, data) {

                // data = [{
                //         "date": "2014-07-01",
                //         "value": 1203
                //     },
                //     {
                //         "date": "2014-07-02",
                //         "value": 480
                //     },
                //     {
                //         "date": "2014-07-03",
                //         "value": 903
                //     },
                //     {
                //         "date": "2014-07-04",
                //         "value": 790
                //     },
                //     {
                //         "date": "2014-07-05",
                //         "value": 1423
                //     },
                //     {
                //         "date": "2014-07-06",
                //         "value": 1222
                //     },
                //     {
                //         "date": "2014-07-07",
                //         "value": 948
                //     },
                //     {
                //         "date": "2014-07-08",
                //         "value": 1338
                //     },
                //     {
                //         "date": "2014-07-09",
                //         "value": 543
                //     },
                //     {
                //         "date": "2014-07-10",
                //         "value": 940
                //     },
                //     {
                //         "date": "2014-07-11",
                //         "value": 1245
                //     },
                //     {
                //         "date": "2014-07-12",
                //         "value": 683
                //     },
                //     {
                //         "date": "2014-07-13",
                //         "value": 898
                //     },
                //     {
                //         "date": "2014-07-14",
                //         "value": 1023
                //     },
                //     {
                //         "date": "2014-07-15",
                //         "value": 857
                //     },
                //     {
                //         "date": "2014-07-16",
                //         "value": 490
                //     },
                //     {
                //         "date": "2014-07-17",
                //         "value": 1009
                //     },
                //     {
                //         "date": "2014-07-18",
                //         "value": 437
                //     },
                //     {
                //         "date": "2014-07-19",
                //         "value": 735
                //     },
                //     {
                //         "date": "2014-07-20",
                //         "value": 865
                //     },
                //     {
                //         "date": "2014-07-21",
                //         "value": 478
                //     },
                //     {
                //         "date": "2014-07-22",
                //         "value": 690
                //     },
                //     {
                //         "date": "2014-07-23",
                //         "value": 954
                //     },
                //     {
                //         "date": "2014-07-24",
                //         "value": 1192
                //     },
                //     {
                //         "date": "2014-07-25",
                //         "value": 586
                //     },
                //     {
                //         "date": "2014-07-26",
                //         "value": 893
                //     },
                //     {
                //         "date": "2014-07-27",
                //         "value": 801
                //     },
                //     {
                //         "date": "2014-07-28",
                //         "value": 1182
                //     },
                //     {
                //         "date": "2014-07-29",
                //         "value": 1026
                //     },
                //     {
                //         "date": "2014-07-30",
                //         "value": 786
                //     },
                //     {
                //         "date": "2014-07-31",
                //         "value": 1056
                //     }
                // ]
                // Show what's wrong if error
                // if (error) return console.error(error);
                    data = data;
                // Pull out values
                data.forEach(function(d) {
                    d.date = parseDate(d.date);
                    d.value = +d.value;
                });

                // Get the maximum value in the given array
                var maxY = d3.max(data, function(d) { return d.value; });

                // Reset start data for animation
                var startData = data.map(function(datum) {
                    return {
                        date: datum.date,
                        value: 0
                    };
                });


                // Set input domains
                // ------------------------------

                // Horizontal
                x.domain(d3.extent(data, function(d, i) { return d.date; }));

                // Vertical
                y.domain([0, d3.max(data, function(d) { return d.value; })]);



                //
                // Append chart elements
                //

                // Add area path
                svg.append("path")
                    .datum(data)
                    .attr("class", "d3-area")
                    .style('fill', color)
                    .attr("d", area)
                    .transition() // begin animation
                    .duration(1000)
                    .attrTween('d', function() {
                        var interpolator = d3.interpolateArray(startData, data);
                        return function(t) {
                            return area(interpolator(t));
                        };
                    });


                // Resize chart
                // ------------------------------

                // Call function on window resize
                $(window).on('resize', messagesAreaResize);

                // Call function on sidebar width change
                $(document).on('click', '.sidebar-control', messagesAreaResize);

                // Resize function
                // 
                // Since D3 doesn't support SVG resize by default,
                // we need to manually specify parts of the graph that need to 
                // be updated on window resize
                function messagesAreaResize() {

                    // Layout variables
                    width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                    // Layout
                    // -------------------------

                    // Main svg width
                    container.attr("width", width + margin.left + margin.right);

                    // Width of appended group
                    svg.attr("width", width + margin.left + margin.right);

                    // Horizontal range
                    x.range([0, width]);


                    // Chart elements
                    // -------------------------

                    // Area path
                    svg.selectAll('.d3-area').datum(data).attr("d", area);
                }
            // });
        }
    }


    // Animated progress with icon
    function loadCheckOutStats(element, radius, border, backgroundColor, foregroundColor, end, iconClass) {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Initialize chart only if element exsists in the DOM
        if (element) {


            // Basic setup
            // ------------------------------

            // Main variables
            var d3Container = d3.select(element),
                startPercent = 0,
                iconSize = 32,
                endPercent = end,
                twoPi = Math.PI * 2,
                formatPercent = d3.format('.0%'),
                boxSize = radius * 2;

            // Values count
            var count = Math.abs((endPercent - startPercent) / 0.01);

            // Values step
            var step = endPercent < startPercent ? -0.01 : 0.01;


            // Create chart
            // ------------------------------

            // Add SVG element
            var container = d3Container.append('svg');

            // Add SVG group
            var svg = container
                .attr('width', boxSize)
                .attr('height', boxSize)
                .append('g')
                .attr('transform', 'translate(' + (boxSize / 2) + ',' + (boxSize / 2) + ')');


            // Construct chart layout
            // ------------------------------

            // Arc
            var arc = d3.svg.arc()
                .startAngle(0)
                .innerRadius(radius)
                .outerRadius(radius - border)
                .cornerRadius(20);


            //
            // Append chart elements
            //

            // Paths
            // ------------------------------

            // Background path
            svg.append('path')
                .attr('class', 'd3-progress-background')
                .attr('d', arc.endAngle(twoPi))
                .style('fill', backgroundColor);

            // Foreground path
            var foreground = svg.append('path')
                .attr('class', 'd3-progress-foreground')
                .attr('filter', 'url(#blur)')
                .style({
                    'fill': foregroundColor,
                    'stroke': foregroundColor
                });

            // Front path
            var front = svg.append('path')
                .attr('class', 'd3-progress-front')
                .style({
                    'fill': foregroundColor,
                    'fill-opacity': 1
                });


            // Text
            // ------------------------------

            // Percentage text value
            var numberText = d3.select('.progress-percentage')
                .attr('class', 'pt-1 mt-2 mb-1');

            // Icon
            d3.select(element)
                .append("i")
                .attr("class", iconClass + " counter-icon")
                .style({
                    'color': foregroundColor,
                    'top': ((boxSize - iconSize) / 2) + 'px'
                });


            // Animation
            // ------------------------------

            // Animate path
            function updateProgress(progress) {
                foreground.attr('d', arc.endAngle(twoPi * progress));
                front.attr('d', arc.endAngle(twoPi * progress));
                numberText.text(formatPercent(progress));
            }

            // Animate text
            var progress = startPercent;
            (function loops() {
                updateProgress(progress);
                if (count > 0) {
                    count--;
                    progress += step;
                    setTimeout(loops, 10);
                }
            })();
        }
    }
    function loadCheckInStats(element, radius, border, backgroundColor, foregroundColor, end, iconClass) {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Initialize chart only if element exsists in the DOM
        if (element) {


            // Basic setup
            // ------------------------------

            // Main variables
            var d3Container = d3.select(element),
                startPercent = 0,
                iconSize = 32,
                endPercent = end,
                twoPi = Math.PI * 2,
                formatPercent = d3.format('.0%'),
                boxSize = radius * 2;

            // Values count
            var count = Math.abs((endPercent - startPercent) / 0.01);

            // Values step
            var step = endPercent < startPercent ? -0.01 : 0.01;


            // Create chart
            // ------------------------------

            // Add SVG element
            var container = d3Container.append('svg');

            // Add SVG group
            var svg = container
                .attr('width', boxSize)
                .attr('height', boxSize)
                .append('g')
                .attr('transform', 'translate(' + (boxSize / 2) + ',' + (boxSize / 2) + ')');


            // Construct chart layout
            // ------------------------------

            // Arc
            var arc = d3.svg.arc()
                .startAngle(0)
                .innerRadius(radius)
                .outerRadius(radius - border)
                .cornerRadius(20);


            //
            // Append chart elements
            //

            // Paths
            // ------------------------------

            // Background path
            svg.append('path')
                .attr('class', 'd3-progress-background')
                .attr('d', arc.endAngle(twoPi))
                .style('fill', backgroundColor);

            // Foreground path
            var foreground = svg.append('path')
                .attr('class', 'd3-progress-foreground')
                .attr('filter', 'url(#blur)')
                .style({
                    'fill': foregroundColor,
                    'stroke': foregroundColor
                });

            // Front path
            var front = svg.append('path')
                .attr('class', 'd3-progress-front')
                .style({
                    'fill': foregroundColor,
                    'fill-opacity': 1
                });


            // Text
            // ------------------------------

            // Percentage text value
            var numberText = d3.select('.progress-percentage')
                .attr('class', 'pt-1 mt-2 mb-1');

            // Icon
            d3.select(element)
                .append("i")
                .attr("class", iconClass + " counter-icon")
                .style({
                    'color': foregroundColor,
                    'top': ((boxSize - iconSize) / 2) + 'px'
                });


            // Animation
            // ------------------------------

            // Animate path
            function updateProgress(progress) {
                foreground.attr('d', arc.endAngle(twoPi * progress));
                front.attr('d', arc.endAngle(twoPi * progress));
                numberText.text(formatPercent(progress));
            }

            // Animate text
            var progress = startPercent;
            (function loops() {
                updateProgress(progress);
                if (count > 0) {
                    count--;
                    progress += step;
                    setTimeout(loops, 10);
                }
            })();
        }
    }
    
</script>


@endsection
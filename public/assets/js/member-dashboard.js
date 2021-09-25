setTimeout(function() {
    $('#from').pickadate();
    $('#to').pickadate();
}, 200)

function loadStats(data, displayLabel, isMemberRenewalFilter = false) {

    draw_graph(data.graphs, displayLabel)

    // if (!isMemberRenewalFilter) {

    //     generateBarChart("#hours-available-bars", 24, 40, true, "elastic", 1200, 50, "#EC407A", "memberships", data.upcomingMemberRenewals.stats);
    //     generateBarChart("#goal-bars", 24, 40, true, "elastic", 1200, 50, "#5C6BC0", "donorships", data.upcomingDonorRenewals.stats);
    //     generateBarChart("#members-online", 24, 50, true, "elastic", 1200, 50, "rgba(255,255,255,0.5)", "members", data.memberDonorProspectStats.members.stats);
    //     generateBarChart("#donors-online", 24, 50, true, "elastic", 1200, 50, "rgba(255,255,255,0.5)", "donors", data.memberDonorProspectStats.donors.stats);
    //     generateBarChart("#prospects-online", 24, 50, true, "elastic", 1200, 50, "rgba(255,255,255,0.5)", "prospects", data.memberDonorProspectStats.prospects.stats);

    //     progressCounter('#hours-available-progress', 38, 2, "#F06292", 789, "icon-bookmark3 text-pink-400", 'Memberships', 'UpComing', data.upcomingMemberRenewals.total)
    //     progressCounter('#goal-progress', 38, 2, "#5C6BC0", 456, "icon-bookmark3 text-indigo-400", 'Donorships', 'UpComing', data.upcomingDonorRenewals.total)
    // }

}

function toggleChartLabels() {
    showTooltips = !showTooltips;
    for (let i = 0; i < charts.length; i++) {
        const chart = charts[i];
        chart.update();

    }
}
//Added by Shahmeer to always show labels on dashboard charts
Chart.pluginService.register({
    beforeRender: function(chart) {
        initiateTooltips(chart);
    },
    afterDraw: function(chart, easing) {
        drawTooltips(chart, easing);
    }
});

function initiateTooltips(chart) {
    // if (chart.config.options.showAllTooltips) {
    // create an array of tooltips
    // we can't use the chart tooltip because there is only one tooltip per chart
    chart.pluginTooltips2 = [];
    chart.config.data.datasets.forEach(function(dataset, i) {
        chart.getDatasetMeta(i).data.forEach(function(sector, j) {
            //console.log(sector);
            chart.pluginTooltips2.push(new Chart.Tooltip({
                _chart: chart.chart,
                _chartInstance: chart,
                _data: chart.data,
                _options: chart.options.tooltips,
                _active: [sector]
            }, chart));
        });
    });
    // turn off normal tooltips
    chart.options.tooltips.enabled = false;
    // }
}

function drawTooltips(chart, easing) {
    // if (chart.config.options.showAllTooltips) {
    // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
    if (!chart.allTooltipsOnce) {
        if (easing !== 1)
            return;
        chart.allTooltipsOnce = true;
    }
    // turn on tooltips
    chart.options.tooltips.enabled = true;
    if (showTooltips) {
        Chart.helpers.each(chart.pluginTooltips2, function(tooltip) {
            //console.log(tooltip);
            tooltip.initialize();
            tooltip.update();
            // we don't actually need this since we are not animating tooltips
            tooltip.pivot();
            tooltip.transition(easing).draw();
        });
        chart.options.tooltips.enabled = false;
    } else {
        SshowTooltips = true;
    }
    // }
}
var charts = [];
var myDatasets = [];
var showTooltips = true;
var SshowTooltips = true;

function draw_graph(graphs, displayLabel) {
    showTooltips = displayLabel;

    for (const [key, graph] of Object.entries(graphs)) {

        var c = document.getElementById(graph.id).getContext('2d');

        var datasets = [{
                label: 'Current ' + graph.period,

                fill: false,
                data: graph.data,
                // borderColor: 'rgb(255, 99, 132)',
            },
            {
                label: 'Previous ' + graph.period,
                fill: false,
                data: graph.prev_data
            }

        ];
        if (graph.lineTension != null) {
            datasets[0].lineTension = graph.lineTension;
            datasets[1].lineTension = graph.lineTension;
            datasets[0].borderWidth = 2;
            datasets[1].borderWidth = 2;
            //var pointRadius = [];
            //for (let i = 0; i < datasets[0].data.length; i++) {
            //    pointRadius.push(3);
            //}
            //datasets[0].pointRadius = pointRadius;
            //datasets[1].pointRadius = pointRadius;
        }

        datasets[0].backgroundColor = 'rgb(255, 99, 132)';
        datasets[1].backgroundColor = 'rgb(154, 208, 244)';

        vOptions = {
            tooltips: {
                //intersect: false,
                mode: 'index',
                displayColors: false,
                backgroundColor: 'rgba(150, 150, 150, 0.6)',
                bodyFontColor: 'rgba(0, 0, 0, 1)',

                filter: function(tooltipItem, data) {
                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    let stop = tooltipItem.datasetIndex + 1;
                    for (let j = 0; j < stop; j++) {
                        if (data.datasets[j]._meta[Object.keys(data.datasets[j]._meta)[0]].hidden) {
                            return false;
                        }
                    }

                    if (tooltipItem.yLabel == 0)
                        return false;
                    return true && (showTooltips || SshowTooltips);
                },
                callbacks: {
                    // Use the footer callback to display the sum of the items showing in the tooltip
                    title: function(tooltipItems, data) {
                        return ''; //skip title
                    },
                    beforeLabel: function(tooltipItems, data) {
                        //console.log('in beforeLabel');
                        return '';
                    },
                    label: function(tooltipItems, data) {
                        var val = 0;
                        //console.log(tooltipItems);
                        val = tooltipItems.yLabel;
                        if (val > 0) {
                            //console.log('in if');
                            if (graph.prefix)
                                return graph.prefix + standardize(val);
                            else
                                return val;
                        } else {
                            //console.log('in else');
                            return '';
                        }
                    },
                },
                footerFontStyle: 'normal',
            },
            showAllTooltips: true,
            legend: {
                labels: {
                    //boxWidth: 0,
                }
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: (graph.type == "line" && graph.lineTension != null) || graph.type == "doughnut" || graph.type == "pie" ? false : true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: graph.y_label ? graph.y_label : ''
                    },
                    ticks: {
                        beginAtZero: true,
                        precision: 0,
                        display: (graph.type == "line" && graph.lineTension != null) || graph.type == "doughnut" || graph.type == "pie" ? false : true,
                        callback: function(value, index, values) {
                            //console.log('in callback' + graph.prefix);
                            if (graph.prefix)
                                return graph.prefix + standardize(value); //to add $ to y-axis labels
                            else
                                return value;
                        }
                    },
                    display: (graph.type == "line" && graph.lineTension != null) || graph.type == "doughnut" || graph.type == "pie" ? false : true
                }],
                xAxes: [{
                    gridLines: {
                        display: (graph.type == "line" && graph.lineTension != null) || graph.type == "doughnut" || graph.type == "pie" ? false : true
                    },
                    ticks: {
                        display: (graph.type == "line" && graph.lineTension != null) || graph.type == "doughnut" || graph.type == "pie" ? false : true,
                    },
                    display: (graph.type == "line" && graph.lineTension != null) || graph.type == "doughnut" || graph.type == "pie" ? false : true
                }]
            },
            ticks: {
                display: false
            },
            legend: {
                display: graph.type == "line" && graph.lineTension != null ? false : true
            },
        };

        var chart = new Chart(c, {

            type: graph.type,

            data: {
                labels: graph.labels,
                datasets: datasets
            },
            options: vOptions
        });
        charts.push(chart);
    }

    // for (const [key, graph] of Object.entries(graphs)) {

    //     var c = document.getElementById(graph.id).getContext('2d');

    //     var datasets = [{
    //         label: 'Current',

    //         fill: false,
    //         data: graph.data,
    //         borderColor: 'rgb(255, 99, 132)',
    //     }];

    //     var chart = new Chart(c, {

    //         type: graph.type,

    //         data: {
    //             labels: graph.labels,
    //             datasets: datasets
    //         },
    //         options: {
    //             legend: {
    //                 display: false
    //             },
    //             scales: {
    //                 yAxes: [{
    //                     scaleLabel: {
    //                         display: true,
    //                         labelString: graph.y_label ? graph.y_label : ''
    //                     },
    //                     ticks: {
    //                         beginAtZero: true,
    //                         precision: 0,
    //                     }
    //                 }]
    //             }
    //         }
    //     });
    // }

}

function standardize(number) {
    number += '';
    var x = number.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1].slice(0, 2) : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function addData(graph) {

    Chart.helpers.each(Chart.instances, function(instance) {
        if (instance.chart.canvas.id == graph.id) {

            instance.data.labels = graph.labels;
            instance.data.datasets[0].data = graph.data;
            instance.data.datasets[1].data = graph.prev_data;
            instance.update();

        }
    })

}

// Chart setup
function generateBarChart(element, barQty, height, animate, easing, duration, delay, color, tooltip, data) {


    // Basic setup
    // ------------------------------

    // Add data set
    var bardata = [];
    var bardates = [];
    for (var i = 0; i < data.length; i++) {
        bardata.push(data[i].data);
        bardates.push(data[i].label);
    }


    // Main variables
    var d3Container = d3.select(element),
        width = d3Container.node().getBoundingClientRect().width;



    // Construct scales
    // ------------------------------

    // Horizontal
    var x = d3.scale.ordinal()
        .rangeBands([0, width], 0.3)

    // Vertical
    var y = d3.scale.linear()
        .range([0, height]);



    // Set input domains
    // ------------------------------

    // Horizontal
    x.domain(d3.range(0, bardata.length))

    // Vertical
    y.domain([0, d3.max(bardata)])



    // Create chart
    // ------------------------------

    // Add svg element
    var container = d3Container.append('svg');

    // Add SVG group
    var svg = container
        .attr('width', width)
        .attr('height', height)
        .append('g');



    //
    // Append chart elements
    //

    // Bars
    var bars = svg.selectAll('rect')
        .data(bardata)
        .enter()
        .append('rect')
        .attr('class', 'd3-random-bars')
        .attr('width', x.rangeBand())
        .attr('x', function(d, i) {
            return x(i);
        })
        .style('fill', color);



    // Tooltip
    // ------------------------------

    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .offset([-10, 0]);

    // Show and hide
    if (tooltip == "memberships" || tooltip == "donorships" || tooltip == "members" || tooltip == "donors" || tooltip == "prospects") {
        bars.call(tip)
            .on('mouseover', tip.show)
            .on('mouseout', tip.hide);
    }

    // Memberships tooltip content
    if (tooltip == "memberships") {
        tip.html(function(d, i) {
            console.log(d, i)
            return "<div class='text-center'>" +
                "<h6 class='no-margin'>" + d + "</h6>" +
                "<span class='text-size-small'>Memberships</span>" +
                "<div class='text-size-small'>" + bardates[i] + "</div>" +
                "</div>"
        });
    }

    // Donorships tooltip content
    if (tooltip == "donorships") {
        tip.html(function(d, i) {
            return "<div class='text-center'>" +
                "<h6 class='no-margin'>" + d + "</h6>" +
                "<span class='text-size-small'>Donorships</span>" +
                "<div class='text-size-small'>" + bardates[i] + "</div>" +
                "</div>"
        });
    }

    // Recent Members tooltip content
    if (tooltip == "members") {
        tip.html(function(d, i) {
            return "<div class='text-center'>" +
                "<h6 class='no-margin'>" + d + "</h6>" +
                "<span class='text-size-small'>Members</span>" +
                "<div class='text-size-small'>" + bardates[i] + "</div>" +
                "</div>"
        });
    }

    // Recent Donors tooltip content
    if (tooltip == "donors") {
        tip.html(function(d, i) {
            return "<div class='text-center'>" +
                "<h6 class='no-margin'>" + d + "</h6>" +
                "<span class='text-size-small'>Donors</span>" +
                "<div class='text-size-small'>" + bardates[i] + "</div>" +
                "</div>"
        });
    }

    // Recent Prospects tooltip content
    if (tooltip == "prospects") {
        tip.html(function(d, i) {
            return "<div class='text-center'>" +
                "<h6 class='no-margin'>" + d + "</h6>" +
                "<span class='text-size-small'>Prospects</span>" +
                "<div class='text-size-small'>" + bardates[i] + "</div>" +
                "</div>"
        });
    }



    // Bar loading animation
    // ------------------------------

    // Choose between animated or static
    if (animate) {
        withAnimation();
    } else {
        withoutAnimation();
    }

    // Animate on load
    function withAnimation() {
        bars
            .attr('height', 0)
            .attr('y', height)
            .transition()
            .attr('height', function(d) {
                return y(d);
            })
            .attr('y', function(d) {
                return height - y(d);
            })
            .delay(function(d, i) {
                return i * delay;
            })
            .duration(duration)
            .ease(easing);
    }

    // Load without animateion
    function withoutAnimation() {
        bars
            .attr('height', function(d) {
                return y(d);
            })
            .attr('y', function(d) {
                return height - y(d);
            })
    }



    // Resize chart
    // ------------------------------

    // Call function on window resize
    $(window).on('resize', barsResize);

    // Call function on sidebar width change
    $(document).on('click', '.sidebar-control', barsResize);

    // Resize function
    // 
    // Since D3 doesn't support SVG resize by default,
    // we need to manually specify parts of the graph that need to 
    // be updated on window resize
    function barsResize() {

        // Layout variables
        width = d3Container.node().getBoundingClientRect().width;


        // Layout
        // -------------------------

        // Main svg width
        container.attr("width", width);

        // Width of appended group
        svg.attr("width", width);

        // Horizontal range
        x.rangeBands([0, width], 0.3);


        // Chart elements
        // -------------------------

        // Bars
        svg.selectAll('.d3-random-bars')
            .attr('width', x.rangeBand())
            .attr('x', function(d, i) {
                return x(i);
            });
    }
}

// Chart setup
function progressCounter(element, radius, border, color, end, iconClass, textTitle, textAverage, data) {


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
    var count = end; //Math.abs((endPercent - startPercent) / 0.01);

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
        .outerRadius(radius - border);



    //
    // Append chart elements
    //

    // Paths
    // ------------------------------

    // Background path
    svg.append('path')
        .attr('class', 'd3-progress-background')
        .attr('d', arc.endAngle(twoPi))
        .style('fill', '#eee');

    // Foreground path
    var foreground = svg.append('path')
        .attr('class', 'd3-progress-foreground')
        .attr('filter', 'url(#blur)')
        .style('fill', color)
        .style('stroke', color);

    // Front path
    var front = svg.append('path')
        .attr('class', 'd3-progress-front')
        .style('fill', color)
        .style('fill-opacity', 1);



    // Text
    // ------------------------------

    // Percentage text value
    var numberText = d3.select(element)
        .append('h2')
        .attr('class', 'mt-15')

    // Icon
    d3.select(element)
        .append("i")
        .attr("class", iconClass + " counter-icon")
        .attr('style', 'top: ' + ((boxSize - iconSize) / 2) + 'px');

    // Title
    d3.select(element)
        .append('div')
        .text(textTitle);

    // Subtitle
    d3.select(element)
        .append('div')
        .attr('class', 'text-size-small text-muted')
        .text(textAverage);



    // Animation
    // ------------------------------

    // Animate path
    function updateProgress(progress) {
        //foreground.attr('d', arc.endAngle(twoPi * progress));
        //front.attr('d', arc.endAngle(twoPi * progress));
        // numberText.text(formatPercent(progress));
        // numberText.text(progress);
        numberText.text(data);
    }

    // Animate text
    // var progress = startPercent;
    var progress = endPercent;
    (function loops() {
        updateProgress(progress);
        if (count > 0) {
            count--;
            progress += step;
            //setTimeout(loops, 10);
        }
    })();
}
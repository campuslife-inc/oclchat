/*=========================================================================================
    File Name: bar.js
    Description: Chartjs bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.1
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bar chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#bar-chart");

    // Chart Options
    var chartOptions = {
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each horizontal bar to be 2px wide and green
        elements: {
            rectangle: {
                borderWidth: 2,
                borderColor: 'rgb(0, 255, 0)',
                borderSkipped: 'left'
            }
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'top',
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }]
        },
        title: {
            display: false,
            text: 'Horizontal Bar Chart'
        }
    };

    // Chart Data
    var chartData = {
        labels: ["Test V", "Test IV", "Test III", "Test II"],
        datasets: [{
            label: "Marks in %",
            data: [65, 59, 80, 81],
            backgroundColor: "#ef8400",
            hoverBackgroundColor: "rgba(255,160,40,.8)",
            borderColor: "transparent"
        }
        // , {
        //     label: "Real Marks",
        //     data: [28, 48, 40, 19],
        //     backgroundColor: "#F98E76",
        //     hoverBackgroundColor: "rgba(249,142,118,.9)",
        //     borderColor: "transparent"
        // }
        ]
    };

    var config = {
        type: 'horizontalBar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
});
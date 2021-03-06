/*=========================================================================================
    File Name: bar-stacked.js
    Description: Chartjs bar stacked chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.1
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bar stacked chart
// ------------------------------
$(window).on("load", function(){

    // Get the context of the Chart canvas element we want to select
    var ctx = $("#bar-stacked");

    // Chart Options
    var chartOptions = {
        title:{
            display:false,
            text:""
        },
        tooltips: {
            mode: 'label'
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        scales: {
            xAxes: [{
                stacked: true,
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
                stacked: true,
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }]
        }
    };

    // Chart Data
    var chartData = {
        labels: ["Computer", "Maths", "English", "Physics", "Lab"],
        datasets: [{
            label: "IIIrd Assignment",
            data: [65, 59, 80, 81, 56],
            backgroundColor: "#5175E0",
            hoverBackgroundColor: "rgba(81,117,224,.8)",
            borderColor: "transparent"
        }
        // , {
        //     label: "My Second Assignment",
        //     data: [28, 48, 40, 19, 86],
        //     backgroundColor: "#28D094",
        //     hoverBackgroundColor: "rgba(22,211,154,.8)",
        //     borderColor: "transparent"
        // },
        // {
        //     label: "My Ninth Assignment",
        //     data: [80, 25, 16, 36, 67],
        //     backgroundColor: "#F98E76",
        //     hoverBackgroundColor: "rgba(249,142,118,.8)",
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
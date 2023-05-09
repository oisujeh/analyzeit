function build_pmtct_bar_chart_with_dual_axis(container_id, title, y_title) {

    Highcharts.chart(container_id, {

        chart: {
            type: 'column'
        },

        title: {
            text: title,
            style: {
                fontSize: '12px'
            }
        },

        xAxis: {
            //categories: categories
            categories: ['Jan 2021', 'Feb 2021', 'Mar 2021', 'Apr 2021', 'May 2021', 'Jun 2021',
                'Jul 2021', 'Aug 2021', 'Sep 2021', 'Oct 2021', 'Nov 2021', 'Dec 2021'],
            crosshair: true
        },

        yAxis: [
            {
                labels: {
                    enabled: false
                },
                title: {
                    text: 'dd'
                }
            },
            { //secondary axis
                min: 0,
                max: 100,
                title: {
                    text: 'Percentage'
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }, { // Tertiary yAxis
                gridLineWidth: 0,
                //title: {
                //    text: 'Sea-Level Pressure',
                //    style: {
                //        color: Highcharts.getOptions().colors[1]
                //    }
                //},

                //labels: {
                //    format: '{value} mb',
                //    style: {
                //        color: Highcharts.getOptions().colors[1]
                //    }
                //},
                opposite: true
            }
        ],
        tooltip: {
            shared: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.ycomma} {point.p}'
                }
            }
        },
        //colors: colors,
        //series: seriesData,
        //series: [{
        //    name: 'No of Life Births',
        //    type: 'column',
        //    yAxis: 1,
        //    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
        //    tooltip: {
        //        valueSuffix: ' mm'
        //    }

        //}, {
        //    name: 'HEI Reived',
        //    type: 'spline',
        //    data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
        //    tooltip: {
        //        valueSuffix: '°C'
        //    }
        //},
        //{
        //    name: 'HEI Reived',
        //    type: 'dot',
        //    data: [99, 15, 9.5, 14.5, 18.2, 21.5, 25.2, 30, 23.3, 18.3, 13.9, 9.6],

        //}],
        series: [{
            name: 'Rainfall',
            type: 'column',
            yAxis: 1,
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
            tooltip: {
                valueSuffix: ' mm'
            }

        }, {
            name: 'Sea-Level Pressure',
            type: 'spline',
            yAxis: 2,
            data: [100, 16, 10, 15.5, 12.3, 9.5, 9.6, 10.2, 13.1, 16.9, 18.2, 16.7],
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot'


        }, {
            name: 'Temperature',
            type: 'spline',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            tooltip: {
                valueSuffix: ' °C'
            }
        }],
        exporting: { enabled: false }
    });


};


function plot_vlc_cascade_charts(container_id, title, y_title, seriesData, colors, categories) {

    Highcharts.chart(container_id, {

        chart: {
            type: 'column'
        },

        title: {
            text: title,
            style: {
                fontSize: '10px'
            }
        },

        xAxis: {
            categories: categories
        },

        yAxis: [
            {
                labels: {
                    enabled: true
                },
                title: {
                    text: ''
                }
            },
            { //secondary axis
                min: 0,
                max: 100,
                title: {
                    text: 'Percentage'
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }
        ],
        tooltip: {
            shared: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.ycomma} {point.p}'
                }
            }
        },
        colors: colors,
        series: seriesData,
        exporting: { enabled: false }
    });


};

function plot_vlc_BuildDonut(id, title, data_array, colors) {
    console.log(data_array);
    if (colors === undefined || colors === null) {
        colors = ['#3A356E', '#A3A8E2', '#9d9b03', '#08bf7A', '#78020f'];
    }

    new Highcharts.Chart({
        chart: {
            renderTo: id,
            type: 'pie'
        },
        title: {
            text: '',
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            pie: {
                //colors: pieColors,
                shadow: false,
                dataLabels: {
                    format: '{point.y:,.0f}<br /> ({point.percentage:.1f} %)'
                }
            }
        },
        tooltip: {
            pointFormat: '{point.y} ({point.percentage:.1f}%)'
        },
        series: [{
            data: data_array,
            size: '80%',
            innerSize: '60%',
            showInLegend: true,

        }],
        credits: {
            enabled: false
        },
        colors: colors,
        exporting: { enabled: false },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    chart: {
                        height: 300
                    },
                    subtitle: {
                        text: null
                    },
                    navigator: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });
}

function plot_vlc_BuildDonut_1(id, title, data_array, colors) {
    console.log(data_array);
    if (colors === undefined || colors === null) {
        colors = ['#3A356E', '#A3A8E2', '#9d9b03', '#08bf7A', '#78020f'];
    }

    new Highcharts.Chart({
        chart: {
            renderTo: id,
            type: 'pie'
        },
        title: {
            text: '',
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            pie: {
                //colors: pieColors,
                shadow: false,
                dataLabels: {
                    format: '{point.y:,.0f}<br /> ({point.percentage:.1f} %)'
                }
            }
        },
        tooltip: {
            pointFormat: '{point.y} ({point.percentage:.1f}%)'
        },
        series: [{
            data: data_array,
            size: '80%',
            innerSize: '60%',
            showInLegend: true,

        }],
        credits: {
            enabled: false
        },
        colors: colors,
        exporting: { enabled: false },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    chart: {
                        height: 300
                    },
                    subtitle: {
                        text: null
                    },
                    navigator: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });
}

// Work in progress...
function plot_vlc_cascade_charts_states(container_id, title, y_title, seriesData, colors, categories) {

    Highcharts.chart(container_id, {

        chart: {
            type: 'column'
        },

        title: {
            text: title,
            style: {
                fontSize: '10px'
            }
        },

        xAxis: {
            categories: categories
        },

        yAxis: [
            {
                labels: {
                    enabled: true
                },
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray',
                        textOutline: 'none'
                    }
                }
            },
            { //secondary axis
                min: 0,
                max: 100,
                title: {
                    text: 'Percentage'
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }
        ],
        tooltip: {
            shared: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.ycomma} {point.p}'
                }
            }
        },
        colors: colors,
        series: seriesData,
        exporting: { enabled: false }
    });


};

// Work in progress...
function plot_vlc_cascade_charts_ips(container_id, title, y_title, seriesData, colors, categories) {

    Highcharts.chart(container_id, {

        chart: {
            type: 'column'
        },

        title: {
            text: title,
            style: {
                fontSize: '10px'
            }
        },

        xAxis: {
            categories: categories
        },

        yAxis: [
            {
                labels: {
                    enabled: true
                },
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray',
                        textOutline: 'none'
                    }
                }
            },
            { //secondary axis
                min: 0,
                max: 100,
                title: {
                    text: 'Percentage'
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }
        ],
        tooltip: {
            shared: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.ycomma} {point.p}'
                }
            }
        },
        colors: colors,
        series: seriesData,
        exporting: { enabled: false }
    });


};

// VL_Cascade charts KeyMetric
function plot_vlc_cascade_charts_VL_Cascade_KeyMetric(container_id, title, y_title, seriesData, colors, categories) {

    Highcharts.chart(container_id, {

        chart: {
            type: 'column'
        },

        title: {
            text: title,
            style: {
                fontSize: '10px'
            }
        },

        xAxis: {
            categories: categories
        },

        yAxis: [
            {
                labels: {
                    enabled: true
                },
                title: {
                    text: ''
                }
            }
            //,
            //{ //secondary axis
            //    min: 0,
            //    max: 100,
            //    title: {
            //        text: 'Percentage'
            //    },
            //    labels: {
            //        format: '{value} %',
            //        style: {
            //            color: Highcharts.getOptions().colors[0]
            //        }
            //    },
            //    opposite: true
            //}
        ],
        tooltip: {
            shared: true
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.ycomma} {point.p}'
                }
            }
        },
        colors: colors,
        series: seriesData,
        exporting: { enabled: false }
    });


};

function plot_vl_cascade_viral_Load_Coverage_BuildDonut(id, title, data_array, colors) {
    console.log(data_array);
    if (colors === undefined || colors === null) {
        colors = ['#3A356E', '#A3A8E2', '#9d9b03', '#08bf7A', '#78020f'];
    }

    new Highcharts.Chart({
        chart: {
            renderTo: id,
            type: 'pie'
        },
        title: {
            text: '',
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            pie: {
                //colors: pieColors,
                shadow: false,
                dataLabels: {
                    format: '{point.y:,.0f}<br /> ({point.percentage:.1f} %)'
                }
            }
        },
        tooltip: {
            pointFormat: '{point.y} ({point.percentage:.1f}%)'
        },
        series: [{
            data: data_array,
            size: '80%',
            innerSize: '60%',
            showInLegend: true,

        }],
        credits: {
            enabled: false
        },
        colors: colors,
        exporting: { enabled: false },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    chart: {
                        height: 300
                    },
                    subtitle: {
                        text: null
                    },
                    navigator: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });
}

function plot_vl_cascade_viral_Load_Suppression_BuildDonut(id, title, data_array, colors) {
    console.log(data_array);
    if (colors === undefined || colors === null) {
        colors = ['#3A356E', '#A3A8E2', '#9d9b03', '#08bf7A', '#78020f'];
    }

    new Highcharts.Chart({
        chart: {
            renderTo: id,
            type: 'pie'
        },
        title: {
            text: '',
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            pie: {
                //colors: pieColors,
                shadow: false,
                dataLabels: {
                    format: '{point.y:,.0f}<br /> ({point.percentage:.1f} %)'
                }
            }
        },
        tooltip: {
            pointFormat: '{point.y} ({point.percentage:.1f}%)'
        },
        series: [{
            data: data_array,
            size: '80%',
            innerSize: '60%',
            showInLegend: true,

        }],
        credits: {
            enabled: false
        },
        colors: colors,
        exporting: { enabled: false },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    chart: {
                        height: 300
                    },
                    subtitle: {
                        text: null
                    },
                    navigator: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });
}


function createChart(chartId, categories, nameSeries1, dataSeries1, nameSeries2, dataSeries2, nameSeries3, dataSeries3, nameSeries4, dataSeries4, nameSeries5, dataSeries5) {
    Highcharts.chart(chartId, {
        chart: {
            type: 'column',
            zoomType: 'xy'
        }, exporting: { enabled: false },
        title: {
            text: ''
        },
        legend: {
            symbolRadius: 0
        },
        xAxis: [
            {
                categories: categories,
                crosshair: true, labels: {
                    rotation: 90
                }
            }
        ],
        yAxis: [
            {
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value, 0, '.', ',');
                    }
                },
                title: {
                    text: ''

                },
                gridLineColor: '#FFF'
            },
            {
                title: {
                    text: ''

                },
                labels: {
                    format: '{value}%'

                },
                min: 0, max: 100,
                // tickInterval: tickInterval,
                opposite: true,
                gridLineColor: '#FFF'
            }
        ],
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: false,
                    crop: false,
                    overflow: 'none'
                },
                pointPadding: 0,
                borderWidth: 0,
                shadow: false
            },
            scatter: {
                dataLabels: {
                    format: '{point.y}%',
                    verticalAlign: 'middle',

                    enabled: false, style: {
                        textShadow: false, textOutline: 0
                    }
                },

                enableMouseTracking: true
            },
            line: {
                dataLabels: {
                    enabled: false
                },
                enableMouseTracking: true
            }

        },
        tooltip: {
            shared: true
        },
        colors: ['#ED745F', '#615D8B', '#4472c4', '#5b9bd5', '#A5A5A5', '#FF0066'],
        series: [
            {
                color: "#ED745F",
                name: nameSeries1,
                data: dataSeries1,
                type: 'column'
            },
            {
                name: nameSeries2,
                data: dataSeries2,
                type: 'column',
                color: "#615D8B"
            },
            {
                name: nameSeries3,
                data: dataSeries3,
                type: 'column',
                color: "#4472c4"
            },
            {
                name: nameSeries4,
                type: 'scatter'
                ,
                marker: {
                    enabled: true,
                    symbol: "radius",
                    radius: 5
                },
                color: "#A5A5A5",
                yAxis: 1,
                data: dataSeries4,
                tooltip: {
                    valueSuffix: '%'
                }
            }, {
                name: nameSeries5,
                type: 'scatter'
                ,
                marker: {
                    enabled: true,
                    symbol: "radius",
                    radius: 5
                },
                color: "#C5e0b4",
                yAxis: 1,
                data: dataSeries5,
                tooltip: {
                    valueSuffix: '%'
                }
            }

        ]
    });
}
function createChart2(chartId, categories, nameSeries1, dataSeries1, nameSeries2, dataSeries2, nameSeries3, dataSeries3, nameSeries4, dataSeries4, nameSeries5, dataSeries5, nameSeries6, dataSeries6) {
    Highcharts.chart(chartId, {
        chart: {
            type: 'column',
            zoomType: 'xy'
        }, exporting: { enabled: false },
        title: {
            text: ''
        },
        legend: {
            symbolRadius: 0
        },
        xAxis: [
            {
                categories: categories,
                crosshair: true, labels: {
                    rotation: 90
                }
            }
        ],
        yAxis: [
            {
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value, 0, '.', ',');
                    }
                },
                title: {
                    text: ''

                },
                gridLineColor: '#FFF'
            },
            {
                title: {
                    text: ''

                },
                labels: {
                    format: '{value}%'

                },
                min: 0, max: 100,
                // tickInterval: tickInterval,
                opposite: true,
                gridLineColor: '#FFF'
            }
        ],
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: false,
                    crop: false,
                    overflow: 'none'
                },
                pointPadding: 0,
                borderWidth: 0,
                shadow: false
            },
            scatter: {
                dataLabels: {
                    format: '{point.y}%',
                    verticalAlign: 'middle',

                    enabled: false, style: {
                        textShadow: false, textOutline: 0
                    }
                },

                enableMouseTracking: true
            },
            line: {
                dataLabels: {
                    enabled: false
                },
                enableMouseTracking: true
            }

        },
        tooltip: {
            shared: true
        },
        colors: ['#ED745F', '#615D8B', '#959335'],
        series: [
            {
                color: "#4472c4",
                name: nameSeries1,
                data: dataSeries1,
                type: 'column'
            },
            {
                name: nameSeries2,
                data: dataSeries2,
                type: 'column',
                // color: "#5C5902"
            },
            {
                name: nameSeries3,
                data: dataSeries3,
                type: 'column',
                // color: "#5C5902"
            },
            {
                name: nameSeries4,
                data: dataSeries4,
                type: 'column',
            },
            {
                name: nameSeries5,
                type: 'scatter'
                ,
                marker: {
                    enabled: true,
                    symbol: "radius",
                    radius: 5
                },
                color: "#002060",
                yAxis: 1,
                data: dataSeries5,
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: nameSeries6,
                type: 'scatter'
                ,
                marker: {
                    enabled: true,
                    symbol: "radius",
                    radius: 5
                },
                // color: "#376555",
                yAxis: 1,
                data: dataSeries6,
                tooltip: {
                    valueSuffix: '%'
                }
            }

        ]
    });
}
function createChart3(chartId, categories, nameSeries1, dataSeries1, nameSeries2, dataSeries2, nameSeries3, dataSeries3, nameSeries4, dataSeries4, nameSeries5, dataSeries5, nameSeries6, dataSeries6, nameSeries7, dataSeries7, nameSeries8, dataSeries8) {
    Highcharts.chart(chartId, {
        chart: {
            type: 'column',
            zoomType: 'xy'
        }, exporting: { enabled: false },
        title: {
            text: ''
        },
        legend: {
            symbolRadius: 0
        },
        xAxis: [
            {
                categories: categories,
                crosshair: true, labels: {
                    rotation: 90
                }
            }
        ],
        yAxis: [
            {
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value, 0, '.', ',');
                    }
                },
                title: {
                    text: ''

                },
                gridLineColor: '#FFF'
            },
            {
                title: {
                    text: ''

                },
                labels: {
                    format: '{value}%'

                },
                min: 0, max: 100,
                // tickInterval: tickInterval,
                opposite: true,
                gridLineColor: '#FFF'
            }
        ],
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: false,
                    crop: false,
                    overflow: 'none'
                },
                pointPadding: 0,
                borderWidth: 0,
                shadow: false
            },
            scatter: {
                dataLabels: {
                    format: '{point.y}%',
                    verticalAlign: 'middle',

                    enabled: false, style: {
                        textShadow: false, textOutline: 0
                    }
                },

                enableMouseTracking: true
            },
            line: {
                dataLabels: {
                    enabled: false
                },
                enableMouseTracking: true
            }

        },
        tooltip: {
            shared: true
        },
        colors: ['#ED745F', '#615D8B', '#959335'],
        series: [
            {
                color: "#4472c4",
                name: nameSeries1,
                data: dataSeries1,
                type: 'column'
            },
            {
                name: nameSeries2,
                data: dataSeries2,
                type: 'column',
                color: "#5C5902"
            },
            {
                name: nameSeries3,
                data: dataSeries3,
                type: 'column',
                color: "#C5e0b4"
            },
            {
                color: "#002060",
                name: nameSeries4,
                data: dataSeries4,
                type: 'column',
            }, {
                name: nameSeries5,
                data: dataSeries5,
                type: 'column',
            },
            {
                name: nameSeries6,
                data: dataSeries6,
                type: 'column',
            },
            {
                name: nameSeries7,
                type: 'scatter'
                ,
                marker: {
                    enabled: true,
                    symbol: "radius",
                    radius: 5
                },
                color: "#376555",
                yAxis: 1,
                data: dataSeries7,
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: nameSeries8,
                type: 'scatter'
                ,
                marker: {
                    enabled: true,
                    symbol: "radius",
                    radius: 5
                },
                color: "#8faadc",
                yAxis: 1,
                data: dataSeries8,
                tooltip: {
                    valueSuffix: '%'
                }
            }

        ]
    });
}

function createthreeConlumChart(chartId, categories, nameSeries1, dataSeries1, nameSeries2, dataSeries2, nameSeries3, dataSeries3) {
    Highcharts.chart(chartId, {
        chart: {
            type: 'column',
            zoomType: 'xy'
        }, exporting: { enabled: false },
        title: {
            text: ''
        },
        legend: {
            symbolRadius: 0
        },
        xAxis: [
            {
                categories: categories,
                crosshair: true, labels: {
                    rotation: 90
                }
            }
        ],
        yAxis: [
            {
                labels: {
                    formatter: function () {
                        return Highcharts.numberFormat(this.value, 0, '.', ',');
                    }
                },
                title: {
                    text: ''

                },
                gridLineColor: '#FFF'
            },
            {
                title: {
                    text: ''

                },
                labels: {
                    format: '{value}%'

                },
                min: 0, max: 100,
                // tickInterval: tickInterval,
                opposite: true,
                gridLineColor: '#FFF'
            }
        ],
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: false,
                    crop: false,
                    overflow: 'none'
                },
                pointPadding: 0,
                borderWidth: 0,
                shadow: false
            },
            scatter: {
                dataLabels: {
                    format: '{point.y}%',
                    verticalAlign: 'middle',

                    enabled: false, style: {
                        textShadow: false, textOutline: 0
                    }
                },

                enableMouseTracking: true
            },
            line: {
                dataLabels: {
                    enabled: false
                },
                enableMouseTracking: true
            }

        },
        tooltip: {
            shared: true
        }, colors: ['#ED745F', '#615D8B', '#959335'],
        series: [
            {
                //color: "#AFAE67",
                name: nameSeries1,
                data: dataSeries1,
                type: 'column'
            },
            {
                name: nameSeries2,
                data: dataSeries2,
                type: 'column',
                // color: "#5C5902"
            },
            {
                name: nameSeries3,
                type: 'column',
                data: dataSeries3,
            }

        ]
    });
}

// Data retrieved from sample demo data, this is for the VL Analytics dasboard on the NDR:
/*function plot_vl_cascade_KeyMetric_column(container_id, title, y_title, seriesData, colors, categories) {
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Major trophies for some English teams',
            align: 'left'
        },
        xAxis: {
            categories: ['Arsenal', 'Chelsea', 'Liverpool', 'Manchester United']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Count trophies'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: ( // theme
                        Highcharts.defaultOptions.title.style &&
                        Highcharts.defaultOptions.title.style.color
                    ) || 'gray',
                    textOutline: 'none'
                }
            }
        },
        legend: {
            align: 'left',
            x: 70,
            verticalAlign: 'top',
            y: 70,
            floating: true,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: 'BPL',
            data: [3, 5, 1, 13]
        }, {
            name: 'FA Cup',
            data: [14, 8, 8, 12]
        }, {
            name: 'CL',
            data: [0, 2, 6, 3]
        }]
    });
}*/



function createStackedChartDrilldownChartIP(container, title = '', indicator, maindata, firstlevel, secondleveldata, thirdleveldata) {
    var drilldownChart, drilldownEvent, drilldownLevel = 0;
    //var maindata = indicator === 'sample_collection_new' ? data.sampleColChartData.iPSampleSeries : res.vlChartData.iPVLSeries;

    Highcharts.chart(container, {
        "chart": {
            "type": "column",
            "events": {
                drilldown: function (e) {
                    if (!e.seriesOptions) {
                        updateGraph(true, this, e);
                    }
                },
                drillup: function (e) {
                    if (!e.seriesOptions.flag) {
                        drilldownLevel = e.seriesOptions._levelNumber;
                        updateGraph(false);
                    }
                }
            }
        },
        "credits": {
            "enabled": false
        },
        "plotOptions": {
            "column": {
                "stacking": "normal",
                "events": {
                    click: function (event) {
                        return false;
                    }
                }
            },
            "series": {
                "borderWidth": 0,
                "dataLabels": {
                    "enabled": true,
                    "style": {
                        "textShadow": false,
                        "fontSize": "10px"
                    }
                }
            }
        },
        "legend": {
            "enabled": true,
            "layout": "vertical",
            "align": "left",
            /*"x": 0,*/
            "verticalAlign": "top",
            /* "y": 140,*/
            "floating": false
        },
        "yAxis": {
            "stackLabels": {
                "enabled": false,
                "style": {
                    "fontWeight": "bold",
                    "color": "gray"
                }
            }
        },
        "title": {
            "text": title,
            "fontWeight": "bold"
        },
        "xAxis": {
            "title": {},
            "type": "category"
        },
        "yAxis": [{
            "title": {
                "text": "Number of Individuals"
            },
            "min": 0,
            "allowDecimals": false
        }, {
            "opposite": true,
            "title": {
                "text": "%"
            },
            "min": 0,
            "max": 100
        }],
        "series": maindata
    });
    //var firstlevel = indicator === 'sample_collection_new' ? res.sampleColChartData.stateSampleSeries : res.vlChartData.stateVLSeries;
    //var secondleveldata = indicator === 'sample_collection_new' ? res.sampleColChartData.lGASampleSeries : res.vlChartData.lGAVLSeries;
    //var thirdleveldata = indicator === 'sample_collection_new' ? res.sampleColChartData.facilitySampleSeries : res.vlChartData.facilityVLSeries;
    function updateGraph(isDrilldown, chart, e) {
        if (isDrilldown) {
            drilldownLevel++;
            drilldownChart = chart;
            drilldownEvent = e;

            if (drilldownLevel === 1) {

                let series = firstlevel.filter(word => word.name === e.point.name).map(a => a.data);

                series.forEach(function (rec) {
                    chart.addSingleSeriesAsDrilldown(e.point, rec);
                });
                chart.applyDrilldown();

            } else if (drilldownLevel === 2) {

                let series2 = secondleveldata.filter(word => word.name === e.point.name).map(a => a.data);

                series2.forEach(function (rec) {
                    chart.addSingleSeriesAsDrilldown(e.point, rec);
                });
                chart.applyDrilldown();

            } else if (drilldownLevel === 3) {
                let series3 = thirdleveldata.filter(word => word.name === e.point.name).map(a => a.data);

                series3.forEach(function (rec) {
                    chart.addSingleSeriesAsDrilldown(e.point, rec);
                });
                chart.applyDrilldown();
            }
        }
    }
}


function createNationalStackedChartDrilldownChart(container, title = '', indicator, maindata, firstlevel, secondleveldata) {
    var drilldownChart, drilldownEvent, drilldownLevel = 0;
    // var maindata = indicator === 'sample_collection_new' ? data.sampleNationalColChartData.stateNatLevelSampleSeries : data.vlNationalChartData.stateNatLevelVLSeries;

    Highcharts.chart(container, {
        "chart": {
            "type": "column",
            "events": {
                drilldown: function (e) {
                    if (!e.seriesOptions) {
                        updateGraph(true, this, e);
                    }
                },
                drillup: function (e) {
                    if (!e.seriesOptions.flag) {
                        drilldownLevel = e.seriesOptions._levelNumber;
                        updateGraph(false);
                    }
                }
            }
        },
        "credits": {
            "enabled": false
        },
        "plotOptions": {
            "column": {
                "stacking": "normal",
                "events": {
                    click: function (event) {
                        return false;
                    }
                }
            },
            "series": {
                "borderWidth": 0,
                "dataLabels": {
                    "enabled": true,
                    "style": {
                        "textShadow": false,
                        "fontSize": "10px"
                    }
                }
            }
        },
        "legend": {
            "enabled": true,
            "layout": "vertical",
            "align": "left",
            /* "x": 0,*/
            "verticalAlign": "top",
            /* "y": 140,*/
            "floating": false
        },
        "yAxis": {
            "stackLabels": {
                "enabled": false,
                "style": {
                    "fontWeight": "bold",
                    "color": "gray"
                }
            }
        },
        "title": {
            "text": title,
            "fontWeight": "bold"
        },
        "xAxis": {
            "title": {},
            "type": "category"
        },
        "yAxis": [{
            "title": {
                "text": "Number of Individuals"
            },
            "min": 0,
            "allowDecimals": true
        }, {
            "opposite": true,
            "title": {
                "text": "%"
            },
            "min": 0,
            "max": 100,
        }],
        "series": maindata
    });
    //var firstlevel = indicator === 'sample_collection_new' ? data.sampleNationalColChartData.lGASampleSeries : data.vlNationalChartData.lGAVLSeries;
    //var secondleveldata = indicator === 'sample_collection_new' ? data.sampleNationalColChartData.facilitySampleSeries : data.vlNationalChartData.facilityVLSeries;
    //var thirdleveldata = indicator === 'sample_collection_new' ? data.sampleNationalColChartData.facilitySampleSeries : data.vlNationalChartData.facilityVLSeries;
    function updateGraph(isDrilldown, chart, e) {
        if (isDrilldown) {
            drilldownLevel++;
            drilldownChart = chart;
            drilldownEvent = e;

            if (drilldownLevel === 1) {

                let series = firstlevel.filter(word => word.name === e.point.name).map(a => a.data);

                series.forEach(function (rec) {
                    chart.addSingleSeriesAsDrilldown(e.point, rec);
                });
                chart.applyDrilldown();

            } else if (drilldownLevel === 2) {

                let series2 = secondleveldata.filter(word => word.name === e.point.name).map(a => a.data);

                series2.forEach(function (rec) {
                    chart.addSingleSeriesAsDrilldown(e.point, rec);
                });
                chart.applyDrilldown();

            } else if (drilldownLevel === 3) {
                let series3 = thirdleveldata.filter(word => word.name === e.point.name).map(a => a.data);

                series3.forEach(function (rec) {
                    chart.addSingleSeriesAsDrilldown(e.point, rec);
                });
                chart.applyDrilldown();
            }
        }
    }
}

// Done
function populate_ribbons(facilities, states, lgas, ips) {
    $("#ribbon-patients").attr("data-end", facilities);
    $("#ribbon-patients").text(facilities.toLocaleString());

    $("#ribbon-lgas").attr("data-end", lgas);
    $("#ribbon-lgas").text(lgas);

    $("#ribbon-facilities").attr("data-end", facilities.toLocaleString());
    $("#ribbon-facilities").text(facilities);

    $("#ribbon-states").attr("data-end", states);
    $("#ribbon-states").text(states);

    $("#ribbon-ips").attr("data-end", ips);
    $("#ribbon-ips").text(ips);
}

// Key Metric
function populateKeyMetric(data) {
    var vlcData = data.keyMetrics;
    var categories = ['Eligible', 'Samples Collected', 'Results Received'];
    const Obj = [{
        name: ["Key Metrics Overview"],
        type: 'bar',
        data: [
            {
                name: "Eligible",
                y: vlcData.eligibleNo,
                color: '#246D38'

            }, {
                name: "Samples Collected",
                y: vlcData.vL_SampleCollected,
                color: '#6CB0A8'
            }, {
                name: "Results Received",
                y: vlcData.vL_SampleResultReceived,
                color: '#687169'
            }
        ]
    }];
    CreateKeyMetricBarChart('KeyMetric', '', categories, 'Number of Individuals', Obj)
}


function CreateKeyMetricBarChart(container, title, categories, yAxisTitle, seriesData) {
    Highcharts.chart(container, {
        chart: {
            type: 'bar'
        },
        title: {
            text: title
        },
        subtitle: {
            text: 'Source: NMRS'
        },
        xAxis: {
            categories: categories,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: yAxisTitle,
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        //tooltip: {
        //    valueSuffix: ' millions'
        //},
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: seriesData
    });
}
// End Key Metric

function populateSampleCollectionOfEligible(data) {
    var vlcData = data.sampleCollectionOfEligible;
    const obj = [
        {
            name: "Sample Collected",
            y: vlcData.vL_SampleCollected
        },
        {
            name: "Sample Not Collected",
            y: vlcData.vL_SamplesNotCollected
        }];
    var colors = ['#246D38', 'rgb(158, 159, 163)'];
    plot_vlc_BuildDonut("SampleCollectionEligible", '', obj, colors);
}

function populateResultReceived(data) {
    var vlcData = data.resultsReceived;

    const obj = [
        {
            name: "Results Received",
            y: vlcData.vL_SampleResultReceived
        },
        {
            name: "Awaiting Results",
            y: vlcData.vL_AwaitingResults
        }];
    var colors = ['#246D38', 'rgb(158, 159, 163)'];
    plot_vlc_BuildDonut_1("resultsReceived", '', obj, colors);
}

function createWeeklySampleCollectionTrendOverChart(container, data) {
    let chartData = data.sampleColTrendOverTime;
    let category = chartData?.map(d => d.range);

    const collectedData = { name: 'Samples Collected', type: 'column', yAxis: 0, color: '#246D38', data: chartData?.map(d => d.sampleCollected) };
    const notCollectedData = { name: 'Samples Not Collected', type: 'column', yAxis: 0, color: '#F2BF48', data: chartData?.map(d => d.sampleNotTaken) };
    const collectionRateData = { name: 'Samples Collection Rate', type: 'scatter', yAxis: 1, color: '#687169', data: chartData?.map(d => d.sampleCollectionRate) };


    Highcharts.chart(container, {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: category,
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                /* format: '{value}°C',*/
                style: {
                    color: 'rgb(158, 159, 163)'
                }
            },
            title: {
                text: 'Number of Individuals',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        },
            { // Secondary yAxis
                title: {
                    text: '%',
                    style: {
                        color: 'rgb(158, 159, 163)'
                    }
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                min: 0,
                max: 100,
                opposite: true
            }],
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Sample Collection Rate: {point.sampleCollectionRate}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
            collectedData,
            notCollectedData,
            collectionRateData
        ]
    });
}

function createWeeklySuppressionTrendOverChart(container, data) {
    let chartData = data.vlSuppressTrendOverTime;
    let category = chartData?.map(d => d.range);

    const collectedData = { name: 'Suppressed', type: 'column', yAxis: 0, color: '#246D38', data: chartData?.map(d => d.suppressed) };
    const notCollectedData = { name: 'Unsuppressed', type: 'column', yAxis: 0, color: '#F2BF48', data: chartData?.map(d => d.unsuppressed) };
    const collectionRateData = { name: 'Viral Load Suppression', type: 'scatter', yAxis: 1, color: '#687169', data: chartData?.map(d => d.viralLoadSuppression) };


    Highcharts.chart(container, {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: category,
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                /* format: '{value}°C',*/
                style: {
                    color: 'rgb(158, 159, 163)'
                }
            },
            title: {
                text: 'Number of Individuals',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        },
            { // Secondary yAxis
                title: {
                    text: '%',
                    style: {
                        color: 'rgb(158, 159, 163)'
                    }
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                min: 0,
                max: 100,
                opposite: true
            }],
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Viral Load Suppression: {point.viralLoadSuppression}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
            collectedData,
            notCollectedData,
            collectionRateData
        ]
    });
}

function createWeeklyCoverageTrendOverChart(container, data) {
    let chartData = data.vlCovTrendOverTime;
    let category = chartData?.map(d => d.range);

    const collectedData = { name: 'VL Coverage', type: 'column', yAxis: 0, color: '#246D38', data: chartData?.map(d => d.vLCoverage) };
    const notCollectedData = { name: 'VL Coverage Gap', type: 'column', yAxis: 0, color: '#F2BF48', data: chartData?.map(d => d.vlTestingGap) };
    const collectionRateData = { name: 'VL Coverage Rate', type: 'scatter', yAxis: 1, color: '#687169', data: chartData?.map(d => d.viralLoadCoverage) };


    Highcharts.chart(container, {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: category,
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                /* format: '{value}°C',*/
                style: {
                    color: 'rgb(158, 159, 163)'
                }
            },
            title: {
                text: 'Number of Individuals',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        },
            { // Secondary yAxis
                title: {
                    text: '%',
                    style: {
                        color: 'rgb(158, 159, 163)'
                    }
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                min: 0,
                max: 100,
                opposite: true
            }],
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Viral Load Coverage: {point.viralLoadCoverage}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
            collectedData,
            notCollectedData,
            collectionRateData
        ]
    });
}



// VL cascade charts
// Viral Load Cascade Key Metric *** Link chart
function populateKeyMetricVL_Cascade(data) {
    var vlcData = data.keyMetrics_VL_Cacade;

    var categories = ['Patients on ART', 'Eligible for VL', 'Result Received', 'Suppressed', 'Low-level Viremia', 'Undetectable' ];
    const Obj = [{
        name: ["Key Metrics Overview"],
        type: 'bar',
        data: [
            {
                name: "Patients on ART",
                y: vlcData.patientsOnART,
                color: '#226C3B'

            },
            {
                name: "Eligible for VL",
                y: vlcData.eligibleNo,
                color: '#2D8F4E'
            },
            {
                name: "Results Received",
                y: vlcData.vL_Coverage,
                color: '#38B261'
            },
            {
                name: "Suppressed",
                y: vlcData.suppressed,
                color: '#73D393'
            },
            {
                name: "Low-level Viremia",
                y: vlcData.llv,
                color: '#96DEAE'
            },
            {
                name: "Undetectable",
                y: vlcData.undetectable,
                color: '#B9E9C9'
            }
        ]
    }];
    console.log('Here here here')
    CreateKeyMetricBarChart('VL_Cascade_KeyMetric', '', categories, 'Number of Individuals', Obj)
    //const Obj = [{
    //    name: ["Key Metric"], type: 'column',
    //    data: [
    //        {
    //            name: "Patient on ART",
    //            y: vlcData.totalRecord

    //        }, {
    //            name: "Eligible",
    //            y: vlcData.eligibleNo

    //        }, {
    //            name: "Results Received",
    //            y: vlcData.vL_SampleResultReceived

    //        }, {
    //            name: "Suppressed",
    //            y: vlcData.vL_SuppressedFromResultRate

    //        }
    //    ]
    //},];

    //var colors = ['#494FA3', '#FFB913'];
    //plot_vlc_cascade_charts_VL_Cascade_KeyMetric("VL_Cascade_KeyMetric", '', '', Obj, colors, ['Patient on ART', 'Eligible', 'Results Recived', 'Suppressed']);

}

// Viral Load coverage
function populateViralLoadCoverageOverview(data) {
    var vlcData = data.viralLoadCoverage;

    const obj = [
        {
            name: "Results Received",
            y: vlcData.vL_Coverage
        },
        {
            name: "Awaiting Result",
            y: vlcData.vL_CoverageGap
        }];
    var colors = ['#246D38', 'rgb(158, 159, 163)'];
    plot_vlc_BuildDonut("viral_Load_Coverage", '', obj, colors);
    //plot_vl_cascade_viral_Load_Coverage_BuildDonut("viral_Load_Coverage", '', obj, colors);
}

/*
 *
 *  var vlcData = data.sampleCollectionOfEligible;
    const obj = [
        {
            name: "Sample Collected",
            y: vlcData.vL_SampleCollected
        },
        {
            name: "Sample Not Yet Collected",
            y: vlcData.vL_SamplesNotCollected
        }];
    var colors = ['#246D38', 'rgb(158, 159, 163)'];
    plot_vlc_BuildDonut("SampleCollectionEligible", '', obj, colors);
 * */

// Viral Load Suppression
function populateViralLoadSuppressionOverview(data) {
    var vlcData = data.viralLoadSuppression;

    const obj = [
        {
            name: "Suppressed",
            y: vlcData.suppressed
        },
        {
            name: "Unsuppressed",
            y: vlcData.unSuppressed
        }
    ];

    var colors = ['#246D38', 'rgb(158, 159, 163)'];
    plot_vlc_BuildDonut("viral_Load_Suppression", '', obj, colors);
    //var colors = ['#ebb7b9', '#ffb913', '#2cffff'];
    //plot_vl_cascade_viral_Load_Suppression_BuildDonut("viral_Load_Suppression", '', obj, colors);
}



//function populateComparativeViewByState(data) {
//    var vlcData = data.comparativeViewState;
//    const Obj = [{
//        name: ["Comparative View By State"], type: 'column',
//        data: [
//            {
//                name: "Sample Collected",
//                y: vlcData.vL_SampleCollectedgroupedStateSum.states,
//                //drilldown: 'vL_SampleCollectedgroupedStateSum'

//            }, {
//                name: "Samples Not Collected",
//                y: vlcData.vL_SampleNotCollectedgroupedStateSum.states

//            }
//            //, {
//            //    name: "Suppressed From Collection Rate",
//            //    y: vlcData.vL_SuppressedFromCollectionRateStateSum

//            //}
//        ]
//    },];

//    var colors = ['#ebb7b9', '#FFB913', '#2cffff'];
//    plot_vlc_cascade_charts_states("vlComparativeViewByState", '', '', Obj, colors, ['Sample Collected', 'Samples Not Collected', 'Suppressed From Collection Rate']);
//}

//function populateComparativeViewByIP(data) {
//    var vlcData = data.comparativeViewIP;
//    const Obj = [{
//        name: ["Comparative View By IP"], type: 'column',
//        data: [
//            {
//                name: "Sample Collected",
//                y: vlcData.vL_SampleCollectedgroupedSIPSum

//            }, {
//                name: "Samples Not Collected",
//                y: vlcData.vL_SampleNotCollectedgroupedIPSum

//            }, {
//                name: "Suppressed From Collection Rate",
//                y: vlcData.vL_SuppressedFromCollectionRateIPSum
//            }
//        ]
//    },];

//    var colors = ['#494FA3', '#FFB913'];
//    plot_vlc_cascade_charts_ips("vlComparativeViewByIP", '', '', Obj, colors, ['Sample Collected', 'Samples Not Collected', 'Suppressed From Collection Rate']);

//}

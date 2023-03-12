function build_clustered_bar_dual_axis(container_id, title, y1_title, y2_title, xaxisCategory, formedData, colors) {

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
            type: 'category'
        },

        yAxis:
            [
                { // primary axis
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: y1_title
                    },
                    labels: {
                        formatter: function () {
                            return this.value;
                        }
                    }
                },
                { //secondary axis
                    min: 0,
                    title: {
                        text: y2_title
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
            shared: false
        },

        plotOptions: {
            column: {
                borderWidth: 0,
                grouping: true,
                pointPadding: 0
            },
            spline: {
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return this.y + '%'
                    }
                }
            }
        },
        //colors: colors,
        series: formedData,
        exporting: { enabled: false },
    });


};


function createStackedChartDrilldownChartIP(container, title = '',  maindata, firstlevel, secondleveldata, thirdleveldata) {
    var drilldownChart, drilldownEvent, drilldownLevel = 0;

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
            "bar": {
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
            "layout": "horizontal",
            "align": "center",
            "verticalAlign": "bottom",
            "itemMarginBottom": 10
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

<script>
    $(document).ready(function() {
        var students =  <?php if (isset($students)) {
            echo json_encode($students);
        } ?>;
        var options = {
            chart: {
                renderTo: 'pie_chart',
                type: 'pie',
            },
            title: {
                text: ''
            },
            legend: {
                reversed: true
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>'+ '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '</b> (' + this.percentage.toFixed(1) + '%)';
                }
            },
                exporting: {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'viewFullscreen', 'separator', 'downloadPNG',
                                'downloadSVG', 'downloadPDF', 'separator', 'downloadXLS'
                            ]
                        },
                    },
                    enabled: true,
                },
                navigation: {
                    buttonOptions: {
                        align: 'right',
                        verticalAlign: 'top',
                        y: 0
                    }
                }, credits: {
                enabled: false
            },

            plotOptions: {
                pie: {
                    shadow: false,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '<br><br></b> (' + this.percentage.toFixed(1) + ' %)';
                        }
                    }
                }
            },
            series: [{
                type:'pie',
                name:'Sex',
                size: '60%',
                innerSize: '50%',
                showInLegend: true,
            }],
            colors: ['#3A356E', '#A3A8E2', '#9d9b03', '#08bf7A78020f'],
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
            },
        }
        myarray = [];
        $.each(students, function(index, val) {
            myarray[index] = [val.sex, val.count];
        });
        options.series[0].data = myarray;
        chart = new Highcharts.Chart(options);

    });
</script>
<script>
    $(document).ready(function() {
        var txcurrAge =  <?php if (isset($txcurrAge)) {
            echo json_encode($txcurrAge);
        } ?>;
        var options = {
            chart: {
                renderTo: 'ageChart',
                type: 'pie',
            },
            title: {
                text: ''
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>'+ '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '</b> (' + this.percentage.toFixed(1) + '%)';
                }
            },
                exporting: {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'viewFullscreen', 'separator', 'downloadPNG',
                                'downloadSVG', 'downloadPDF', 'separator', 'downloadXLS'
                            ]
                        },
                    },
                    enabled: true,
                },
                navigation: {
                    buttonOptions: {
                        align: 'right',
                        verticalAlign: 'top',
                        y: 0
                    }
                }, credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '<br><br></b> (' + this.percentage.toFixed(1) + ' %)';
                        }
                    }
                }
            },
            series: [{
                type:'pie',
                name:'age_range',
                size: '60%',
                innerSize: '50%',
                showInLegend: true,

            }],
            colors: ['#CAC99A','#AFAE67','#959335','#7A7802'],
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
            },
        }
        myarray = [];
        $.each(txcurrAge, function(index, val) {
            myarray[index] = [val.age_range, val.count];
        });
        options.series[0].data = myarray;
        chart = new Highcharts.Chart(options);

    });
</script>
<script>
    $(document).ready(function() {
        var studentsNew =  <?php if (isset($studentsNew)) {
            echo json_encode($studentsNew);
        } ?>;
        var options = {
            chart: {
                renderTo: 'newSexChart',
                type: 'pie',
            },
            title: {
                text: ''
            },
            legend: {
                reversed: true
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>'+ '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '</b> (' + this.percentage.toFixed(1) + '%)';
                }
            },
                exporting: {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'viewFullscreen', 'separator', 'downloadPNG',
                                'downloadSVG', 'downloadPDF', 'separator', 'downloadXLS'
                            ]
                        },
                    },
                    enabled: true,
                },
                navigation: {
                    buttonOptions: {
                        align: 'right',
                        verticalAlign: 'top',
                        y: 0
                    }
                }, credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '<br><br></b> (' + this.percentage.toFixed(1) + ' %)';
                        }
                    }
                }
            },
            series: [{
                type:'pie',
                name:'Sex',
                size: '60%',
                innerSize: '50%',
                showInLegend: true,
            }],
            colors: ['#3A356E', '#A3A8E2', '#9d9b03', '#08bf7A78020f'],
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
        }
        myarray = [];
        $.each(studentsNew, function(index, val) {
            myarray[index] = [val.sex, val.count];
        });
        options.series[0].data = myarray;
        chart = new Highcharts.Chart(options);

    });
</script>
<script>
    $(document).ready(function() {
        var txnewAge =  <?php if (isset($txnewAge)) {
            echo json_encode($txnewAge);
        } ?>;
        var options = {
            chart: {
                renderTo: 'newAgeChart',
                type: 'pie',
            },
            title: {
                text: ''
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>'+ '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '</b> (' + this.percentage.toFixed(1) + '%)';
                }
            },
                exporting: {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'viewFullscreen', 'separator', 'downloadPNG',
                                'downloadSVG', 'downloadPDF', 'separator', 'downloadXLS'
                            ]
                        },
                    },
                    enabled: true,
                },
                navigation: {
                    buttonOptions: {
                        align: 'right',
                        verticalAlign: 'top',
                        y: 0
                    }
                }, credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<br>'+'<b>' + this.point.y.toLocaleString('en-US') + '<br><br></b> (' + this.percentage.toFixed(1) + ' %)';
                        }
                    }
                }
            },
            series: [{
                type:'pie',
                name:'age_range',
                size: '60%',
                innerSize: '50%',
                showInLegend: true,

            }],
            colors: ['#CAC99A','#AFAE67','#959335','#7A7802'],
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
            },
        }
        myarray = [];
        $.each(txnewAge, function(index, val) {
            myarray[index] = [val.age_range, val.count];
        });
        options.series[0].data = myarray;
        chart = new Highcharts.Chart(options);

    });
</script>
{{--<script>
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "{{route('treatment.filter')}}",
            data: {
                states: '',
                lga: '',
                facilities: '',
                report_type: 'vl'
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {

            build_bar_chart_dual_axis(
                "pvlsStateChart",
                null,
                'Number of Patients',
                '% Suppression',
                data.states,
                data.eligibleWithVl,
                'Viral Load Results',
                data.viralLoadSuppressed,
                'Suppression',
                data.percentage_viral_load_suppressed,
                '% Suppression',
                false,
                "State");
        });

    });
</script>--}}

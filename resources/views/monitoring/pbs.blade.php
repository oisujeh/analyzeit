<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid sm:grid-cols-1">
                    <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-content">
                            <div id="container"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    @section('footer_scripts')
        <script src="http://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        <!--        <script src="http://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>-->
        <script src="http://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
        <script src="http://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <!--        <script src="http://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>-->
        <script src="http://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script src="http:///cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>

        <script>
            var tx_curr =  <?php if (isset($active)) {
                echo json_encode($active,JSON_NUMERIC_CHECK);
            } ?>

            var captured =  <?php if (isset($captured)) {
                echo json_encode($captured,JSON_NUMERIC_CHECK);
            } ?>;

            var notcaptured =  <?php if (isset($notcaptured)) {
                echo json_encode($notcaptured,JSON_NUMERIC_CHECK);
            } ?>

            var valid =  <?php if (isset($valid)) {
                echo json_encode($valid,JSON_NUMERIC_CHECK);
            } ?>;

            var invalid =  <?php if (isset($invalid)) {
                echo json_encode($invalid,JSON_NUMERIC_CHECK);
            } ?>;


            ipSeries = [{ name: 'TxCurr', data: 34000},
            ];


            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'PBS Aggregrate Data across States, LGA and Facilities'
                },
                colors: ['#959335', '#053E2B', '#F88944', '#A3A8E2', '#494FA3', '#CAC99A', '#494FA3', '#ED745F', '#615D8B', '#959335', '#CAC99A'],
                /*subtitle: {
                    text: 'Source: WorldClimate.com'
                },*/
                xAxis: {
                    categories: [
                        'APIN'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'PBS'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            menuItems: [
                                'viewFullscreen', 'separator', 'downloadPNG',  'separator', 'downloadSVG'
                            ]
                        },
                    },
                    enabled: true,
                },
                plotOptions: {
                    column: {
                        pointPadding: 0,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'TxCurr',
                    data: [tx_curr[0].active]

                }, {
                    name: 'Captured',
                    data: [captured[0].captured]

                }, {
                    name: 'No Fingerprint',
                    data: [notcaptured[0].notcaptured]

                }, {
                    name: 'Valid Fingers',
                    data: [valid[0].valid]

                },{
                    name: 'Invalid Fingers',
                    data: [invalid[0].invalid]

                }
                ]
            });
        </script>
    @endsection
</x-app-layout>

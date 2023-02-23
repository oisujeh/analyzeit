<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="col-span-1 bg-white drop-shadow-md">
                            <div class="box-content">
                                <div id="chart-container"></div>
                            </div>
                    </div>

                    <!-- <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-heading ml-2 mt-2">
                            Number of Adults and Children currently receiving ART by Sex
                        </div>
                        <div class="box-content">
                            <div class="chart" id="pie_chart">
                            </div>
                        </div>
                    </div> -->
                    <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-content">
                            <div class="chart" id="ageChart"></div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-heading ml-2 mt-2">
                            Number of Adults and Children newly enrolled on ART by Sex
                        </div>
                        <div class="box-content">
                            <div class="chart" id="newSexChart"></div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-heading ml-2 mt-2">
                            Number of Adults and Children newly enrolled on ART by Age
                        </div>
                        <div class="box-content">
                            <div class="chart" id="newAgeChart"></div>
                        </div>
                    </div>


                    <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-content">
                            <div id="chart-container"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid sm:grid-cols-1 bg-white drop-shadow-md mt-4 text-xs">
                <div class="container mx-auto">
                    <h4 class=" ml-2 mt-2 text-gray-700 text-bold">TREATMENT OVERVIEW BY STATES</h4>
                    <div class="flex flex-col">
                        <div class="w-full">
                            <div class="p-4 border-b border-gray-200 shadow">
                                <!-- <table> -->
                                <table id="emr-table" class="p-4 max-w-full w-full mx-auto myTables whitespace-nowrap">

                                        <thead>
                                        <tr>
                                            <th class="text-left">State</th>
                                            <th>LGA</th>
                                            <th>Facility Name</th>
                                            <th>Datim code</th>
                                            <th>Total Patients</th>
                                            <th>TX CURR</th>
                                            <th>IIT</th>
                                            <th>Transferred Out</th>
                                            <th>Dead</th>
                                            <th>Stopped</th>
                                            <th>PBS</th>
                                            <th>TX NEW</th>
                                            <th>EMR Last Date</th>
                                        </tr>
                                        </thead>

                                    <tbody>
                                    @foreach($performance as $list)
                                        <tr class="hover:bg-gray-200 font-medium">
                                            <td class="w-150 px-4 py-2 border">{{$list->state}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->lga}}</td>
                                            <td class="w-100 px-4 py-2 border">{{ Illuminate\Support\Str::limit($list->facility_name, 50, $end='...') }}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->datim_code}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->total_patients}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->active}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->ltfu}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->transferred_out}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->dead}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->stopped}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->pbs}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->tx_new}}</td>
                                            <td class="w-150 px-4 py-2 border">{{$list->emr_date}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
        @include('dashboardscripts.scripts')
        <script>
            var table = $('.myTables').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });

           /* new $.fn.dataTable.FixedHeader(table);*/
        </script>
        <script>
            $(document).ready(function(){
                $('.myTables').DataTable({
                    "processing":true,
                    "serverside":true,
                    "ajax": {
                        "url": "{{route('performance')}}",
                        "type": "POST",
                        "dataType": "json",
                        "data": {"_token":"{{csrf_token() }}"}
                    },
                    "columns":[
                        {"data":"state","orderable":false},
                        {"data":"lga","orderable":false},
                        {"data":"facility_name","orderable":false},
                        {"data":"datim_code","orderable":false},
                        {"data":"tx_curr","orderable":false},
                        {"data":"iit","orderable":false},
                        {"data":"transferred_out","orderable":false},
                        {"data":"dead","orderable":false},
                        {"data":"stopped","orderable":false},
                        {"data":"pbs","orderable":false},
                        {"data":"tx_new","orderable":false},
                        {"data":"emr_date","orderable":false},
                    ],
                    language:{
                        processing: '<img src="/img/loader.gif" alt="" />'
                    },
                    columnDefs: [
                        {"orderable":false, "targets":0}
                    ]
                });
            });
        </script>
        <script>
$(function () {
    Highcharts.chart('chart-container', {
        chart: {
            renderTo: 'chart-container',
            type: 'variablepie'
        },
        title: {
            text: 'Number of Adults and Children currently receiving ART'
        },credits: {
            enabled: false
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                'Tx_Curr: <b>{point.x}</b><br/>' +
                'Male: <b>{point.y}</b><br/>' +
                'Female: <b>{point.z}</b><br/>'
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
        series: [{
            name: 'Browsers',
            minPointSize: 10,
            innerSize: '20%',
            size: '80%',
            zMin: 0,
            data: {!! json_encode($tx_curr) !!}
        }]
    });
});
</script>

    @endsection
</x-app-layout>

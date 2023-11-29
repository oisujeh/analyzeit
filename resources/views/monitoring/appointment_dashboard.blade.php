<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Appointment Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-xl">
                <div class="grid sm:grid-cols-1 bg-gray-50 drop-shadow-md mt-4">
                    <ul class="mb-5 mr-5 ml-5 mt-4 flex list-none flex-col flex-wrap border-b-0 pl-0 md:flex-row bg-gray-100"
                        role="tablist"
                        data-te-nav-ref>
                        <li role="presentation" class="flex-grow basis-0 text-center">
                            <a href="#tabs-home02" class="my-2 block border-x-0 border-t-0 border-b-2 border-transparent
                            px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 focus:isolate
                            data-[te-nav-active]:bg-black data-[te-nav-active]:text-white dark:text-neutral-400  dark:data-[te-nav-active]:text-white"
                                data-te-toggle="pill"
                                data-te-target="#tabs-home02"
                                data-te-nav-active
                                role="tab"
                                aria-controls="tabs-home02"
                                aria-selected="true"
                            >Today's Appointments</a>
                        </li>
                        <li role="presentation" class="flex-grow basis-0 text-center">
                            <a href="#tabs-profile02" class="my-2 block border-x-0 border-t-0 border-b-2 border-transparent
                            px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 focus:isolate
                            data-[te-nav-active]:bg-black data-[te-nav-active]:text-white dark:text-neutral-400  dark:data-[te-nav-active]:text-white"
                                data-te-toggle="pill"
                                data-te-target="#tabs-profile02"
                                role="tab"
                                aria-controls="tabs-profile02"
                                aria-selected="false"
                            >Tomorrow's Appointments</a>
                        </li>
                        <li role="presentation" class="flex-grow basis-0 text-center">
                            <a
                                href="#tabs-messages02"
                                class="my-2 block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 focus:isolate data-[te-nav-active]:bg-black data-[te-nav-active]:text-white dark:text-neutral-400  dark:data-[te-nav-active]:text-white"
                                data-te-toggle="pill"
                                data-te-target="#tabs-messages02"
                                role="tab"
                                aria-controls="tabs-messages02"
                                aria-selected="false"
                            >Missed Appointments</a>
                        </li>
                    </ul>
                    <div class="mb-6 mr-5 ml-5">

                        <!--Tab One Starts Here-->
                        <div class="hidden text-center opacity-0 opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                            id="tabs-home02" role="tabpanel" aria-labelledby="tabs-home-tab02" data-te-tab-active>

                            <!-- Tab1 Cards -->
                            <div class="grid sm:grid-cols-1 lg:grid-cols-2 shadow-sm divide-y overflow-hidden sm:flex sm:divide-y-0 sm:divide-x dark:shadow-slate-700/[.7] dark:divide-gray-600">
                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-suitcase text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($todaysAppt['stats']->total_Appointments) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total appointments for today
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-list-ul text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($todaysAppt['stats']->total_Appointments_valid_no) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total valid numbers
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-envelope-upload text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($todaysAppt['stats']->total_sent) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total SMS sent
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-clock text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($todaysAppt['stats']->total_not_sent) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total pending SMS
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-phone-slash text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($todaysAppt['stats']->total_appointments_invalid_no) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Phone not reachable
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab1 Cards Ends-->

                            <!-- Chart Data -->
                            <div class="mt-5">
                                <div id="today_appointments_chart"></div>
                            </div>
                            <!-- Chart End -->

                            <div class="flex flex-col mt-5">
                                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full text-left myTables text-sm font-light whitespace-nowrap">
                                                <thead
                                                    class="border-b bg-white font-medium">
                                                <tr>
                                                    <th scope="col" class="px-6 py-4">LGA</th>
                                                    <th scope="col" class="px-6 py-4">Total Appointments</th>
                                                    <th scope="col" class="px-6 py-4">Total Valid Numbers</th>
                                                    <th scope="col" class="px-6 py-4">Total Sent SMS</th>
                                                    <th scope="col" class="px-6 py-4">Total Pending SMS</th>
                                                    <th scope="col" class="px-6 py-4">Phone not reachable</th>
                                                    <th scope="col" class="px-6 py-4">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data['today_appointments']['list'] as $key => $r)
                                                    <tr
                                                        class="border-b bg-neutral-100">
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->lga ?? '')}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{$r->total_Appointments ?? ''}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{$r->total_Appointments_valid_no ?? ''}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->total_sent ?? '')}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->total_not_sent ?? '')}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->total_appointments_invalid_no ?? '')}}</td>
                                                        <td><a target="_blank" href="<?php echo url('admin/appointment-list?q=').strtolower($r->lga) . "&&apt=1"?>"
                                                               class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm
                                                               rounded-md text-white bg-green-300 uppercase hover:bg-green-700">download</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Tab One Ends Here-->

                        <div class="hidden text-center opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                            id="tabs-profile02" role="tabpanel" aria-labelledby="tabs-profile-tab02">
                            <!-- Tab2 Cards -->
                            <div class="grid sm:grid-cols-1 lg:grid-cols-2 shadow-sm divide-y overflow-hidden sm:flex sm:divide-y-0 sm:divide-x dark:shadow-slate-700/[.7] dark:divide-gray-600">
                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-suitcase text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($tomorrowsAppt['stats']->total_Appointments) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total appointments for tomorrow
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-list-ul text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($tomorrowsAppt['stats']->total_Appointments_valid_no) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total valid numbers
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-envelope-upload text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($tomorrowsAppt['stats']->total_sent) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total SMS sent
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-clock text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($tomorrowsAppt['stats']->total_not_sent) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Total pending SMS
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-[1_0_0%] bg-white">
                                    <div class="p-4 flex-1 md:p-5">
                                        <i class="uil uil-phone-slash text-2xl"></i>
                                        <h2 class="text-2xl text-bold"><span>{!! number_format($tomorrowsAppt['stats']->total_appointments_invalid_no) !!}</span></h2>
                                        <p class="mt-1 text-gray-800 text-xs">
                                            Phone not reachable
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab2 Cards Ends-->

                            <!-- Chart Data -->
                            <div class="mt-5">
                                <div id="tomorrow_appointments_chart"></div>
                            </div>
                            <!-- Chart End -->

                            <div class="flex flex-col mt-5">
                                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full text-left myTables text-sm font-light whitespace-nowrap">
                                                <thead
                                                    class="border-b bg-white font-medium">
                                                <tr>
                                                    <th scope="col" class="px-6 py-4">LGA</th>
                                                    <th scope="col" class="px-6 py-4">Total Appointments</th>
                                                    <th scope="col" class="px-6 py-4">Total Valid Numbers</th>
                                                    <th scope="col" class="px-6 py-4">Total Sent SMS</th>
                                                    <th scope="col" class="px-6 py-4">Total Pending SMS</th>
                                                    <th scope="col" class="px-6 py-4">Phone not reachable</th>
                                                    <th scope="col" class="px-6 py-4">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data['tomorrow_appointments']['list'] as $key => $r)
                                                    <tr
                                                        class="border-b bg-neutral-100">
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->lga ?? '')}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{$r->total_Appointments ?? ''}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{$r->total_Appointments_valid_no ?? ''}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->total_sent ?? '')}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->total_not_sent ?? '')}}</td>
                                                        <td class="whitespace-nowrap px-6 py-4">{{ucfirst($r->total_appointments_invalid_no ?? '')}}</td>
                                                        <td><a target="_blank" href="<?php echo url('admin/appointment-list?q=').strtolower($r->lga) . "&&apt=1"?>"
                                                               class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm
                                                               rounded-md text-white bg-green-300 uppercase hover:bg-green-700">download</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                            id="tabs-messages02"
                            role="tabpanel"
                            aria-labelledby="tabs-profile-tab02">
                            Tab 3 content
                        </div>
                        <div
                            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                            id="tabs-contact02"
                            role="tabpanel"
                            aria-labelledby="tabs-contact-tab02">
                            Tab 4 content
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
        </script>
        @parent
        <script type="text/javascript">
            var dataToday = <?php echo json_encode($data['dashboardGraphs']['today_lga_list'])?>;
            var dataTomorrow = <?php echo json_encode($data['dashboardGraphs']['tomorrow_lga_list'])?>;

            var today_appointments_graph_drilldown = <?php echo json_encode($data[
            'dashboardGraphs']['today_appointments_graph_drilldown'])?>;

            var tomorrow_appointments_graph_drilldown = <?php echo json_encode($data[
            'dashboardGraphs']['tomorrow_appointments_graph_drilldown'])?>;

            console.log(today_appointments_graph_drilldown);

            plotGraphsWithDrilldown(
                "Today's appointments by State",
                dataToday,
                today_appointments_graph_drilldown,
                "today_appointments_chart",
                "Number of patients per State"
            );

            plotGraphsWithDrilldown(
                "Tomorrow's appointments by State",
                dataTomorrow,
                tomorrow_appointments_graph_drilldown,
                "tomorrow_appointments_chart",
                "Number of patients per State"
            );


            function plotGraphsWithDrilldown(graphTitle, data, graph_drilldown, chartId, yTitle) {

                var target = [];
                $.each(data, function(index, value) {
                    target.push({
                        'name': value.name,
                        'y': parseInt(value.y),
                        'drilldown': value.name
                    });
                });

                // Create the chart
                Highcharts.chart(chartId, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: graphTitle
                    },
                    subtitle: {
                        text: '<a href="http://127.0.0.1:8000/admin/state-appointments?q=benue&&apt=3" target="_blank">Click Here to get full line list </a> '
                        //text: 'Click  <a href="http://127.0.0.1:8000/admin/state-appointments?q=benue&&apt=3" target="_blank"><b>Here</b></a> below to get full line list '
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: yTitle
                        }

                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.0f}'
                            },
                            point: {
                                events: {
                                    click: function() {
                                        //alert(this.options);
                                        console.log(this.options);

                                        if (this.options != null) {
                                            var url = this.options.name;
                                            var facility = url.split("|");
                                            if (facility) {
                                                window.open(
                                                    baseURL+'appointments/admin/state-appointments?apt=1&&q=' +
                                                    facility[1], '_blank');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} patients</b> of total<br/>'
                    },exporting: {
                        buttons: {
                            contextButton: {
                                menuItems: [
                                    'viewFullscreen', 'separator', 'downloadPNG',
                                    'downloadSVG', 'downloadPDF'
                                ]
                            },
                        },
                        enabled: true,
                    },
                    series: [{
                        name: "State",
                        colorByPoint: true,
                        data: target
                    }],
                    drilldown: {
                        series: graph_drilldown
                    }
                });

            }
        </script>

    @endsection
</x-app-layout>

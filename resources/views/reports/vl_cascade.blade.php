<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Viral Load Cascade by State') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-1 bg-white drop-shadow-md mt-4 text-md">
                <div class="container mx-auto">
                    <div class="flex flex-col">
                        <div class="w-full">
                            <div class="p-4 border-b border-gray-200 shadow">
                                <!-- <table> -->
                                <table id="emr-table" class="p-4 max-w-full w-full mx-auto myTables">

                                    <thead>
                                    <tr class="text-md font-semibold text-center border-b-2 border-blue-500">
                                        <th class="border">State</th>
                                        <th class="border">Tx_Curr</th>
                                        <th class="border">Eligible</th>
                                        <th class="border">Sample Collected</th>
                                        <th class="border">Eligible with Result</th>
                                        <th class="border">Coverage</th>
                                        <th class="border">Suppressed</th>
                                        <th class="border">% Suppressed</th>
                                        <th class="border text-red-600">GAP</th>
                                        <th class="border bg-indigo-100">VL < 50</th>
                                        <th class="border bg-indigo-100">VL 50 - 999</th>
                                        <th class="border bg-indigo-100">Unsuppressed</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($vlCascade as $list)
                                        <tr class="hover:bg-gray-200 font-medium">
                                            <td class="px-4 py-2 border">{{$list->state}}</td>
                                            <td class="px-4 py-2 border">{{number_format($list->active) }}</td>
                                            <td class="px-4 py-2 border">{{number_format($list->eligible)}}</td>
                                            <td class="px-4 py-2 border">{{number_format($list->samp_collected)}}</td>
                                            <td class="px-4 py-2 border">{{number_format($list->vl_result)}}</td>
                                            <td class="px-4 py-2 border">{{$list->percent_result}}</td>
                                            <td class="px-4 py-2 border">{{number_format($list->suppressed)}}</td>
                                            <td class="px-4 py-2 border">{{$list->percent_suppressed}}</td>
                                            <td class="px-4 py-2 border">{{number_format($list->gap)}}</td>
                                            <td class="px-4 py-2 border bg-indigo-100">{{number_format($list->result_lt_50)}}</td>
                                            <td class="px-4 py-2 border bg-indigo-100">{{number_format($list->result_50_999)}}</td>
                                            <td class="px-4 py-2 border bg-indigo-100">{{number_format($list->result_gt_999)}}</td>
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
        <script src="http://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="http://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
        <script src="http://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
        <script src="http://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
        <script src="http://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script src="http:///cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
        @include('dashboardscripts.scripts')
    @endsection
</x-app-layout>

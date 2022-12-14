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
                        <div class="box-heading ml-2 mt-2">
                            Number of Adults and Children currently receiving ART by Sex
                        </div>
                        <div class="box-content">
                            <div class="chart" id="pie_chart">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white drop-shadow-md">
                        <div class="box-heading ml-2 mt-2">
                            Number of Adults and Children currently receiving ART by Age
                        </div>
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

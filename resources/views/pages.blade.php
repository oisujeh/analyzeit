<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program Monitoring (MER Indicators') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-12 gap-4">
                    <!--Start side bar -->
                    @include('monitoring.sidebar')
                    <!-- end side bar -->

                    <!-- Main content -->
                    <div class="col-span-9">
                        @include('monitoring.heading_content')
                        @include('monitoring.tx_new')
                        @include('monitoring.tx_curr')
                        @include('monitoring.vl')
                    </div>
                    <!-- End main content -->
                </div>
        </div>
    </div>
    @section('footer_scripts')
        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="{{ asset('assets/select2.js') }}"></script>
        <script src="{{asset('assets/filter.js')}}"></script>
        <script>
            $(document).ready(function() {
                $('.e2').select2({
                    placeholder: "Choose...",
                    maximumSelectionLength: 2,
                    allowClear: true
                });
            });
        </script>
        <script>
            let selectedIndicator = null;

            function updateSelectedIndicator(value) {
                selectedIndicator = value;

                if (['tx_curr', 'tx_pvls'].indexOf(selectedIndicator) === -1) {
                    document.getElementById('div1').style.display = 'block';
                } else {
                    document.getElementById('div1').style.display = 'none';
                }

                if (selectedIndicator === 'tx_curr') {
                    document.getElementById('tx_curr').style.display = 'block';
                } else {
                    document.getElementById('tx_curr').style.display = 'none';
                }

                if (selectedIndicator === 'tx_new') {
                    document.getElementById('tx_new').style.display = 'block';
                } else {
                    document.getElementById('tx_new').style.display = 'none';
                }

                if (selectedIndicator === 'tx_pvls') {
                    document.getElementById('tx_pvls').style.display = 'block';
                } else {
                    document.getElementById('tx_pvls').style.display = 'none';
                }
            }
        </script>
    @endsection
</x-app-layout>

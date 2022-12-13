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
                    </div>
                    <!-- End main content -->
                </div>
        </div>
    </div>
    @section('footer_scripts')

    @endsection
</x-app-layout>

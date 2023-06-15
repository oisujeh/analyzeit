<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <link href=" https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('code/css/custom.css')}}" rel="stylesheet" type="text/css" />
<!--        <link href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />-->
        <link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet"
              type="text/css" />
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">

<!--        <link rel="stylesheet" href="https://bootswatch.com/5/minty/bootstrap.min.css">-->


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->

    </head>
    <body class="font-sans antialiased">
        <style>
            /* Adjust the layout for screens smaller than 640px */
            @media (max-width: 640px) {
                .grid-cols-12 {
                    grid-template-columns: 1fr;
                }

                .md\:grid-cols-3 {
                    grid-template-columns: 1fr;
                }
            }

            /* Adjust the layout for screens larger than 640px */
            @media (min-width: 641px) {
                .grid-cols-12 {
                    grid-template-columns: repeat(12, minmax(0, 1fr));
                }

                .md\:grid-cols-3 {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }
        </style>
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div id="app">
                    {{ $slot }}
                </div>

            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://code.highcharts.com/maps/highmaps.js"></script>
        <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/mapdata/countries/ng/ng-all.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
        <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
        <script src="{{asset('assets/highcharts-utils.js')}}"></script>
        <script src="{{asset('./assets/vendor/preline/dist/preline.js')}}"></script>


        @yield('footer_scripts')
    </body>
</html>

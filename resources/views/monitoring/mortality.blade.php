<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center" id="loading" style="display:none">
        <div class="inline-block h-8 w-8 animate-[spinner-grow_0.75s_linear_infinite] rounded-full bg-current align-[-0.125em]
            text-primary opacity-0 motion-reduce:animate-[spinner-grow_1.5s_linear_infinite]" role="status">
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
        </div>
        <div class="inline-block h-8 w-8 animate-[spinner-grow_0.75s_linear_infinite] rounded-full bg-current align-[-0.125em]
            text-secondary opacity-0 motion-reduce:animate-[spinner-grow_1.5s_linear_infinite]" role="status">
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
        </div>
        <div class="inline-block h-8 w-8 animate-[spinner-grow_0.75s_linear_infinite] rounded-full bg-current align-[-0.125em]
            text-success opacity-0 motion-reduce:animate-[spinner-grow_1.5s_linear_infinite]" role="status">
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4">

                <!--Start side bar -->
                <div class="col-span-3 bg-white h-fit rounded p-4 drop-shadow-md">
                    <p class="text-sm font-medium">APPLY FILTERS BELOW TO LOAD DATA</p>

                    <!--begin::Form-->
                    <form id="filters" method="POST">

                        <div class="col-span-6 sm:col-span-3 hidden">
                            <label for="directorate" class="block text-sm text-gray-500 mt-3">
                                <i class="uil uil-list-ul"></i> Select MER Indicator
                            </label>

                            <select id="selectIndicator" name="selectIndicator" class="select2 mt-1 block w-full py-2 px-3
                                border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500
                                focus:border-indigo-500 sm:text-sm">
                                <option value="ms" selected></option>
                            </select>
                        </div>

                        <!-- States -->
                        <div class="col-span-6 sm:col-span-3">
                            <label for="state" class="block text-sm text-gray-500 mt-5">
                                <i class="uil uil-map-pin-alt"></i> States
                            </label>
                            <select id="state" name="state"
                                    class="e2 select2 mt-1 block w-full py-2 px-3 border
                                        border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    multiple="multiple">
                                <option value="" disabled></option>
                                <option value="7">Benue</option>
                                <option value="28">Ogun</option>
                                <option value="29">Ondo</option>
                                <option value="31">Oyo</option>
                                <option value="32">Plateau</option>
                            </select>
                        </div>
                        <!-- End States -->

                        <div class="col-span-6 sm:col-span-3">
                            <label for="lga" class="block text-sm text-gray-500 mt-5">
                                <i class="uil uil-map-pin-alt"></i> LGAs
                            </label>
                            <select id="lga" name="lga" class="e2 select2 mt-1 block w-full h-4 py-2 px-3 border border-gray-300
                                bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                                sm:text-sm" data-toggle="select2" multiple="multiple">
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="facility" class="block text-sm text-gray-500 mt-5">
                                <i class="uil uil-box"></i> Facilities
                            </label>
                            <select id="facility" name="facility" class="e2 select2 select2-selection--multiple mt-1
                                block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" data-toggle="select2" multiple="multiple">
                            </select>
                        </div>
                        <div id="div1">
                            <div class="col-span-6 sm:col-span-3 mt-5">
                                <label for="cat" class="block text-sm text-gray-500">
                                    <i class="uil uil-schedule"></i> From Date
                                </label>
                                <input type="date" name="start_date" id="start_date"
                                       class="mt-1 focus:ring-indigo-500 w-full
                                               shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-5 ">
                                <label for="cat" class="block text-sm text-gray-500">
                                    <i class="uil uil-schedule"></i> To Date
                                </label>
                                <input type="date" name="end_date" id="end_date"
                                       class="mt-1 focus:ring-indigo-500 block
                                           w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-3 mt-5 text-left">
                            <button class="inline-flex justify-center py-2 px-4 border border-transparent
                                    shadow-sm text-sm font-bold rounded-md text-white bg-indigo-500 hover:bg-indigo-700
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Load Data
                            </button>

                            <button type="reset" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm
                                        text-sm font-bold rounded-md text-white bg-gray-500 hover:bg-gray-700 focus:ring-2
                                        focus:ring-offset-2 focus:ring-indigo-500">Clear
                            </button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>

                <!-- end side bar -->

                <!-- Main content -->
                <div class="col-span-9">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="col-span-1 bg-white drop-shadow-md rounded p-4 text-center">
                            <div class="text-indigo-700">
                                <p class="text-xl"><i class="uil uil-users-alt"></i> PATIENTS</p>
                                <p class="tx_patient" >...</p>
                            </div>
                        </div>
                        <div class="col-span-1 bg-white drop-shadow-md rounded p-4 text-center">
                            <div class="text-red-500 ">
                                <p class="text-xl"><i class="uil uil-hospital"></i> FACILITIES</p>
                                <p class="tx_facilities">...</p>
                            </div>
                        </div>
                        <div class="col-span-1 bg-white drop-shadow-md rounded p-4 text-center">
                            <div class="text-green-600">
                                <p class="text-xl"><i class="uil uil-location-point"></i> LGAs</p>
                                <p class="tx_lgas">...</p>
                            </div>
                        </div>
                        <div class="col-span-1 bg-white drop-shadow-md rounded p-4 text-center">
                            <div class="text-red-700">
                                <p class="text-xl"><i class="uil uil-location-point"></i> STATES</p>
                                <p class="tx_states">...</p>
                            </div>
                        </div>
                    </div>


                    <div class="grid grid-cols-1 mt-6">
                        <div class="col-span-1 bg-white drop-shadow-md relative">
                            <div class="box-content">
                                <div class="chart" id="msDrillDown">
                                </div>
                            </div>
                        </div>
                    </div>





                </div>
                <!-- End main content -->
            </div>
        </div>
    </div>


    @section('footer_scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="{{asset('assets/select2.js') }}"></script>
        <script src="{{asset('assets/filter.js')}}"></script>

        <script>
            $(".e2").select2({
                allowClear: true
            });


            $("#filters").submit(function(event){
                $('#loading').show();
                let selectReports = $('#selectIndicator');

                var state = [];
                $('#state :selected').each(function(){
                    state.push($(this).val());
                });

                var lga = [];
                $('#lga :selected').each(function(){
                    lga.push($(this).val());
                });

                var facility = [];
                $('#facility :selected').each(function(){
                    facility.push($(this).val());
                });

                var formData = $("#filters").serializeArray();
                formData.push({
                    name: 'states',
                    value: state
                }, {
                    name: 'lgas',
                    value: lga
                },{
                    name: 'facilities',
                    value: facility
                });
                $(".tx_curr").html('...')
                $(".tx_new").html('...')
                $(".tx_facilities").html('...')
                $(".tx_states").html('...')
                $(".tx_lgas").html('...')
                $(".tx_eligible").html('...')

                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "{{route('mortality.filter')}}",
                    data: formData,
                    dataType: 'json',
                    encode: true,
                }).done(function(data) {
                    var response = data.mortality_stats;
                    if (selectReports.val() === 'ms') {
                        console.log(data);
                        buildDataCharts(data);
                    }
                }).fail(function(xhr) {
                    if (xhr.status === 401) {
                        alert("Your Session has expired. Click ok to redirect to login page");
                        window.location.reload();
                    } else {
                        alert("There was an error fetching the data");
                    }
                });
                event.preventDefault();
            });
        </script>
        <script>
            function buildDataCharts(data) {
                /*let data = data.msDatas;*/
                buildMsDrilldownChart(data.new_state_data);
                /*let totalTxCurr = res.txCurr;
                let totalIit = res.totalIit;
                let totalDead = res.totalDead;
                let totalStates = res.totalStates;
                let ips = res.totalIps;

                let suppressed = [];
                let unSuppressed = [];
                let noViralLoadResult = [];
                let hasViralLoad = [];
                let males = [];
                let females = [];
                //let totalDeaths = [];
                //Disaggregation by Age and State
                let currentAgeLt1 = [];
                let currentAgeB14 = [];
                let currentAge5To9 = [];
                let currentAge10To14 = [];
                let currentAge15To19 = [];
                let currentAge20To24 = [];
                let currentAge25To29 = [];
                let currentAge30To34 = [];
                let currentAge35To39 = [];
                let currentAge40To44 = [];
                let currentAge45To49 = [];
                let currentAge50P = [];
                //------------------------------

                //for disaggregation by age band and sex

                let sexAgeband_F = [];
                let sexAgeBand_m = [];

                //-------------------------
                let artDurationLt1 = [];
                let artDurationGtEq1LtEq2 = [];
                let artDurationGt2LtEq3 = [];
                let artDurationGt3LtEq4 = [];
                let artDurationGt4LtEq5 = [];
                let artDurationGt5 = [];
                let cd4L200 = [];
                let cd4GT_200 = [];
                let cd4_200_349 = [];
                let cd4_350_500 = [];
                let cd4Gt500 = [];
                let noCd4Result = [];
                let percentageDeaths = [];
                let txCurr = [];
                let iit = [];

                let stateDeaths = [];
                let stateDeathRates = [];
                let statesData = [];
                var ipStateList = groupArrayByKey(data, 'stateName');
                var states = Object.keys(ipStateList);
                //var ipList = groupArrayByKey(data, 'ip');
                //var ipx = Object.keys(ipList);

                let msTxCurr = $('#ms-txCurr');
                let msDead = $('#ms-dead');
                let msIit = $('#ms-iit');
                let msStates = $('#ms-states');
                let msIps = $('#ms-ips');

                //const fy = $("#from").val() !== null && $("#from").val().length > 0? new Date($("#from").val()).getFullYear().toString() : new Date().getFullYear().toString();

                states.forEach(function (stateName, i) {
                    var stateFacilities = ipStateList[stateName];
                    var stateObj =
                        {
                            name: stateName,
                            suppressed: 0,
                            unsuppressed: 0,
                            noViralLoadResult: 0,
                            hasViralLoad: 0,
                            males: 0,
                            females: 0,
                            txCurr: 0,
                            iit: 0,
                            cd4L200: 0,
                            cd4GT_200: 0,
                            //cd4_200_349: 0,
                            //cd4_350_500: 0,
                            //cd4Gt500: 0,
                            noCd4Result: 0,
                            artDurationLt1: 0,
                            artDurationGtEq1LtEq2: 0,
                            artDurationGt2LtEq3: 0,
                            artDurationGt3LtEq4: 0,
                            artDurationGt4LtEq5: 0,
                            artDurationGt5: 0,
                            currentAge5To9_F: 0,
                            currentAge5To9_M: 0,
                            currentAge10To14_F: 0,
                            currentAge10To14_M: 0,
                            currentAge15To19_F: 0,
                            currentAge15To19_M: 0,
                            currentAge20To24_F: 0,
                            currentAge20To24_M: 0,
                            currentAge25To29_F: 0,
                            currentAge25To29_M: 0,
                            currentAge30To34_F: 0,
                            currentAge30To34_M: 0,
                            currentAge35To39_F: 0,
                            currentAge35To39_M: 0,
                            currentAge40To44_F: 0,
                            currentAge40To44_M: 0,
                            currentAge45To49_F: 0,
                            currentAge45To49_M: 0,
                            currentAge50P_F: 0,
                            currentAge50P_M: 0,
                            currentAgeB14_F: 0,
                            currentAgeB14_M: 0,
                            currentAgeLt1_F: 0,
                            currentAgeLt1_M: 0,
                            totalDied: 0,
                            facilityTotalDeath: 0
                        };

                    stateFacilities.forEach(function (f, o) {
                        stateObj.txCurr += f.txCurr;
                        stateObj.iit += f.iit;
                        stateObj.suppressed += f.suppressed;
                        stateObj.unsuppressed += f.unsuppressed;
                        stateObj.noViralLoadResult += f.noViralLoadResult;
                        stateObj.hasViralLoad += (f.unsuppressed + f.suppressed);

                        stateObj.cd4L200 += f.cD4L200;
                        stateObj.cd4GT_200 += f.cD4GT_200
                        stateObj.noCd4Result += f.noCd4Result;
                        //stateObj.cd4_200_349 += f.cD4_200_349;
                        //stateObj.cd4_350_500 += f.cD4_350_500;
                        //stateObj.cd4Gt500 += f.cD4Gt500;

                        stateObj.artDurationLt1 += f.artDurationLt1;
                        stateObj.artDurationGtEq1LtEq2 += f.artDurationGtEq1LtEq2;
                        stateObj.artDurationGt2LtEq3 += f.artDurationGt2LtEq3;
                        stateObj.artDurationGt3LtEq4 += f.artDurationGt3LtEq4;
                        stateObj.artDurationGt4LtEq5 += f.artDurationGt4LtEq5;
                        stateObj.artDurationGt5 += f.artDurationGt5;

                        stateObj.currentAgeLt1_F += f.currentAgeLt1_F;
                        stateObj.currentAgeLt1_M += f.currentAgeLt1_M;
                        stateObj.currentAgeB14_F += f.currentAgeB14_F;
                        stateObj.currentAgeB14_M += f.currentAgeB14_M;
                        stateObj.currentAge5To9_F += f.currentAge5To9_F;
                        stateObj.currentAge5To9_M += f.currentAge5To9_M;
                        stateObj.currentAge10To14_F += f.currentAge10To14_F;
                        stateObj.currentAge10To14_M += f.currentAge10To14_M;
                        stateObj.currentAge15To19_F += f.currentAge15To19_F;
                        stateObj.currentAge15To19_M += f.currentAge15To19_M;
                        stateObj.currentAge20To24_F += f.currentAge20To24_F;
                        stateObj.currentAge20To24_M += f.currentAge20To24_M;
                        stateObj.currentAge25To29_F += f.currentAge25To29_F;
                        stateObj.currentAge25To29_M += f.currentAge25To29_M;
                        stateObj.currentAge30To34_F += f.currentAge30To34_F;
                        stateObj.currentAge30To34_M += f.currentAge30To34_M;
                        stateObj.currentAge35To39_F += f.currentAge35To39_F;
                        stateObj.currentAge35To39_M += f.currentAge35To39_M;
                        stateObj.currentAge40To44_F += f.currentAge40To44_F;
                        stateObj.currentAge40To44_M += f.currentAge40To44_M;
                        stateObj.currentAge45To49_F += f.currentAge45To49_F;
                        stateObj.currentAge45To49_M += f.currentAge45To49_M;
                        stateObj.currentAge50P_F += f.currentAge50P_F;
                        stateObj.currentAge50P_M += f.currentAge50P_M;

                        stateObj.females += f.females;
                        stateObj.males += f.males;
                        stateObj.totalDied += f.facilityTotalDeath;
                    });

                    statesData.push(stateObj);
                    suppressed.push({name: stateName, y: stateObj.suppressed});
                    unSuppressed.push({name: stateName, y: stateObj.unsuppressed});
                    noViralLoadResult.push({name: stateName, y: stateObj.noViralLoadResult});
                    hasViralLoad.push({name: stateName, y: stateObj.hasViralLoad});

                    males.push({name: stateName, y: stateObj.males});
                    females.push({name: stateName, y: stateObj.females});
                    //totalDeaths.push({ name: stateName, y: stateObj.totalDied });
                    txCurr.push({name: stateName, y: stateObj.txCurr});
                    iit.push({name: stateName, y: stateObj.iit});

                    //age and state
                    currentAgeLt1.push({name: stateName, y: (stateObj.currentAgeLt1_F + stateObj.currentAgeLt1_M)});
                    currentAgeB14.push({name: stateName, y: (stateObj.currentAgeB14_F + stateObj.currentAgeB14_M)});
                    currentAge5To9.push({name: stateName, y: (stateObj.currentAge5To9_F + stateObj.currentAge5To9_M)});
                    currentAge10To14.push({
                        name: stateName,
                        y: (stateObj.currentAge10To14_F + stateObj.currentAge10To14_M)
                    });
                    currentAge15To19.push({
                        name: stateName,
                        y: (stateObj.currentAge15To19_F + stateObj.currentAge15To19_M)
                    });
                    currentAge20To24.push({
                        name: stateName,
                        y: (stateObj.currentAge20To24_F + stateObj.currentAge20To24_M)
                    });
                    currentAge25To29.push({
                        name: stateName,
                        y: (stateObj.currentAge25To29_F + stateObj.currentAge25To29_M)
                    });
                    currentAge30To34.push({
                        name: stateName,
                        y: (stateObj.currentAge30To34_F + stateObj.currentAge30To34_M)
                    });
                    currentAge35To39.push({
                        name: stateName,
                        y: (stateObj.currentAge35To39_F + stateObj.currentAge35To39_M)
                    });
                    currentAge40To44.push({
                        name: stateName,
                        y: (stateObj.currentAge40To44_F + stateObj.currentAge40To44_M)
                    });
                    currentAge45To49.push({
                        name: stateName,
                        y: (stateObj.currentAge45To49_F + stateObj.currentAge45To49_M)
                    });
                    currentAge50P.push({name: stateName, y: (stateObj.currentAge50P_F + stateObj.currentAge50P_M)});*/

                    //age and sex -------------------------------------------------------------------------------
                    /*addDisgg(sexAgeband_F, '<1', stateObj.currentAgeLt1_F);
                    addDisgg(sexAgeBand_m, '<1', -stateObj.currentAgeLt1_M);
                    addDisgg(sexAgeband_F, '1-4', stateObj.currentAgeB14_F);
                    addDisgg(sexAgeBand_m, '1-4', -stateObj.currentAgeB14_M);
                    addDisgg(sexAgeband_F, '5-9', stateObj.currentAge5To9_F);
                    addDisgg(sexAgeBand_m, '5-9', -stateObj.currentAge5To9_M);
                    addDisgg(sexAgeband_F, '10-14', stateObj.currentAge10To14_F);
                    addDisgg(sexAgeBand_m, '10-14', -stateObj.currentAge10To14_M);
                    addDisgg(sexAgeband_F, '15-19', stateObj.currentAge15To19_F);
                    addDisgg(sexAgeBand_m, '15-19', -stateObj.currentAge15To19_M);
                    addDisgg(sexAgeband_F, '20-24', stateObj.currentAge20To24_F);
                    addDisgg(sexAgeBand_m, '20-24', -stateObj.currentAge20To24_M);
                    addDisgg(sexAgeband_F, '25-29', stateObj.currentAge25To29_F);
                    addDisgg(sexAgeBand_m, '25-29', -stateObj.currentAge25To29_M);
                    addDisgg(sexAgeband_F, '30-34', stateObj.currentAge30To34_F);
                    addDisgg(sexAgeBand_m, '30-34', -stateObj.currentAge30To34_M);
                    addDisgg(sexAgeband_F, '35-39', stateObj.currentAge35To39_F);
                    addDisgg(sexAgeBand_m, '35-39', -stateObj.currentAge35To39_M);
                    addDisgg(sexAgeband_F, '40-44', stateObj.currentAge40To44_F);
                    addDisgg(sexAgeBand_m, '40-44', -stateObj.currentAge40To44_M);
                    addDisgg(sexAgeband_F, '45-49', stateObj.currentAge45To49_F);
                    addDisgg(sexAgeBand_m, '45-49', -stateObj.currentAge45To49_M);
                    addDisgg(sexAgeband_F, '50+', stateObj.currentAge50P_F);
                    addDisgg(sexAgeBand_m, '50+', -stateObj.currentAge50P_M);*/

                    //--------------------------------------------------------------------------------

                    /*artDurationLt1.push({name: stateName, y: stateObj.artDurationLt1});
                    artDurationGtEq1LtEq2.push({name: stateName, y: stateObj.artDurationGtEq1LtEq2});
                    artDurationGt2LtEq3.push({name: stateName, y: stateObj.artDurationGt2LtEq3});
                    artDurationGt3LtEq4.push({name: stateName, y: stateObj.artDurationGt3LtEq4});
                    artDurationGt4LtEq5.push({name: stateName, y: stateObj.artDurationGt4LtEq5});
                    artDurationGt5.push({name: stateName, y: stateObj.artDurationGt5});

                    cd4L200.push({name: stateName, y: stateObj.cd4L200});
                    cd4GT_200.push({name: stateName, y: stateObj.cd4GT_200});
                    noCd4Result.push({name: stateName, y: stateObj.noCd4Result});

                    stateDeaths.push({name: stateName, y: stateObj.totalDied});*/

                    //cd4_200_349.push({ name: stateName, y: stateObj.cd4_200_349 });
                    //cd4_350_500.push({ name: stateName, y: stateObj.cd4_350_500 });
                    //cd4Gt500.push({ name: stateName, y: stateObj.cd4Gt500 });

                }
                /*msTxCurr.text(totalTxCurr.toLocaleString());
                msDead.text(totalDead.toLocaleString());
                msIit.text(totalIit.toLocaleString());
                msIps.html(ips.toLocaleString());
                //msIps.text(ipx.length.toLocaleString());
                msStates.text(totalStates.toLocaleString());*/
                //let vlSeries = [{ name: 'Suppressed', data: suppressed }, { name: 'Unsuppressed', data: unSuppressed }, {name: 'No Viral Load Result', data:
                //                 noViralLoadResult}];
                /*let vlSeries = [{name: 'Has Viral Load', data: hasViralLoad}, {
                    name: 'No Viral Load Result',
                    data: noViralLoadResult
                }];
                let sexSeries = [{name: 'Males', data: males}, {name: 'Females', data: females}];
                //let totalDeathsSeries = [{ name: 'TXCURR', data: txCurr }, { name: 'IIT', data: iit }, { name: 'Total Deaths', data: totalDeaths }];
                let deathsByAgeSeries =
                    [
                        {name: '<1', data: currentAgeLt1},
                        {name: '1-4', data: currentAgeB14},
                        {name: '5-9', data: currentAge5To9},
                        {name: '10-14', data: currentAge10To14},
                        {name: '15-19', data: currentAge15To19},
                        {name: '20-24', data: currentAge20To24},
                        {name: '25-29', data: currentAge25To29},
                        {name: '30-34', data: currentAge30To34},
                        {name: '35-39', data: currentAge35To39},
                        {name: '40-44', data: currentAge40To44},
                        {name: '45-49', data: currentAge45To49},
                        {name: '50+', data: currentAge50P}
                    ];
                //noCd4Result   noViralLoadResult
                let artDurationSeries =
                    [
                        {name: '<1 year', data: artDurationLt1},
                        //{ name: '>= 1 year, <= 2 years', data: artDurationGtEq1LtEq2 },
                        {name: '1 year - 3 years', data: artDurationGt2LtEq3},
                        //{ name: '>3 years, <= 4 years', data: artDurationGt3LtEq4 },
                        {name: '> 3 years, >= 5 years', data: artDurationGt4LtEq5},
                        {name: '> 5 years', data: artDurationGt5}
                    ];
                let cd4Series =
                    [
                        {name: '< 200', data: cd4L200},
                        {name: '>= 200', data: cd4GT_200},
                        //{ name: '200-349', data: cd4_200_349 },
                        //{ name: '350-500s', data: cd4_350_500 },
                        //{ name: '>500', data: cd4Gt500 },
                        {name: 'Not Recorded', y: noCd4Result}
                    ];*/


                //For state chart
                /*const letTotalDeaths = stateDeaths.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);
                stateDeaths.map(function myFunction(s) {
                    stateDeathRates.push((s.y / letTotalDeaths) * 100);
                });
                let statesSeries =
                    [
                        {name: 'Number of Deaths', data: stateDeaths, type: 'column'},
                        {
                            name: 'Death Rate',
                            data: stateDeathRates,
                            type: 'scatter',
                            tooltip: {pointFormat: 'Death Rate: <b>{point.y:.1f}%</b>'},
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.1f}%'
                            },
                            yAxis: 1,
                            marker: {symbol: 'square', rotation: 45}
                        }
                    ];

                //Sex Disaggregation Pie chart
                let ttMales = males.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);

                let ttFemales = females.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);
                let ttx = ttMales + ttFemales;
                let totalMales = (ttMales / ttx) * 100;
                let totalFemales = (ttFemales / ttx) * 100;

                //CD4 Disaggregation Pie
                let ttL200s = cd4L200.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);

                let ttGtEq200s = cd4GT_200.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);
                let ttNoCd4 = noCd4Result.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);


                //let tt200To349s = cd4_200_349.reduce((accumulator, object) =>
                //{
                //    return accumulator + object.y;
                //}, 0);
                //let tt350To500s = cd4_350_500.reduce((accumulator, object) =>
                //{
                //    return accumulator + object.y;
                //}, 0);
                //let ttGt500s = cd4Gt500.reduce((accumulator, object) =>
                //{
                //    return accumulator + object.y;
                //}, 0);


                //CD4L200 CD4GT_200 NoCd4Result

                //let ttCd4 = (ttL200s + ttGtEq200s + tt350To500s + ttGt500s + ttNoCd4);
                let ttCd4 = (ttL200s + ttGtEq200s + ttNoCd4);
                let totalL200s = (ttL200s / ttCd4) * 100;
                let totalGtEq200s = (ttGtEq200s / ttCd4) * 100;
                let totalNoCd4 = (ttNoCd4 / ttCd4) * 100;

                //let total200To349s = (tt200To349s/ttCd4)* 100;
                //let total350To500s = (tt350To500s/ttCd4)* 100;
                //let totalGt500ss = (ttGt500s/ttCd4)* 100;

                //VL suppression pie chart
                let ttSuppressed = suppressed.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);
                let ttUnsuppressed = unSuppressed.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);
                let ttNoViralLoadResult = noViralLoadResult.reduce((accumulator, object) => {
                    return accumulator + object.y;
                }, 0);

                let ttVl = (ttSuppressed + ttUnsuppressed + ttNoViralLoadResult);
                let percentSuppressed = (ttSuppressed / ttVl) * 100;
                let percentUnsuppressed = (ttUnsuppressed / ttVl) * 100;
                let percentNoVl = (ttNoViralLoadResult / ttVl) * 100;*/


                /*let deathsByAgeAndSexSeries =
                    [
                        {name: 'Male', data: sexAgeBand_m, type: 'bar'},
                        {name: 'Female', data: sexAgeband_F, type: 'bar'},
                    ];

                //---------------------------------------------
                let rgLines = [];
                let clls = ['rgb(121,150,164)', 'rgb(76,130,55)', 'rgb(121,150,164)', '#0d47a1', '#93911b', '#607d8b'];
                if (res.regimenLineQs && res.regimenLineQs.length > 0) {
                    res.regimenLineQs.forEach(function (rg, i) {
                        rgLines.push({name: rg.name, y: parseInt(rg.y), color: clls[i]});
                    });
                }

                chartsDisp.show();
                let categories = ['<1', '1-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50+'];

                Highcharts.chart('msSexPie',
                    {
                        chart:
                            {
                                type: 'pie'
                            },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions:
                            {
                                pie:
                                    {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>:<br>{point.y} ({point.percentage:.1f}%)'
                                        },
                                        showInLegend: true
                                    }
                            },
                        title:
                            {
                                text: 'Dead Clients Disaggregated by Sex'
                            },
                        colors: ['#4a148c', '#7b1fa2'],
                        tooltip:
                            {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y} ({point.percentage:.1f}%) <b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                        series:
                            [
                                {
                                    name: 'Death rates by Sex',
                                    colorByPoint: true,
                                    innerSize: '60%',
                                    data: [{
                                        name: 'Males',
                                        y: ttMales
                                    }, {
                                        name: 'Females',
                                        y: ttFemales
                                    }]
                                }
                            ]
                    });
                Highcharts.chart('msCd4Pie',
                    {
                        chart:
                            {
                                type: 'pie'
                            },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions:
                            {
                                pie:
                                    {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>:<br>{point.y} ({point.percentage:.1f}%)'
                                        },
                                        showInLegend: true
                                    }
                            },
                        title:
                            {
                                text: 'Dead Clients Disaggregated by Last CD4 counts'
                            },
                        colors: ['#3b5998', '#0d47a1', '#607d8b', '#64b5f6', '#1565c0'],
                        tooltip:
                            {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y} ({point.percentage:.1f}%) <b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                        series:
                            [
                                {
                                    name: 'Death rates by Last CD4',
                                    colorByPoint: true,
                                    innerSize: '60%',
                                    data:
                                        [{name: '<200 c/ml', y: ttL200s},
                                            {name: '>= 200 c/ml', y: ttGtEq200s},
                                            {name: 'Not Recorded', y: ttNoCd4}
                                            //,{ name: '200-349 c/ml', y: total200To349s },
                                            //{ name: '350-500 c/ml', y: total350To500s },
                                            //{ name: '>500 c/ml', y: totalGt500ss },

                                        ]
                                }
                            ]
                    });
                Highcharts.chart('msDeathsByAge',
                    {
                        chart:
                            {
                                type: 'bar'
                            },
                        plotOptions:
                            {
                                series:
                                    {
                                        stacking: 'normal'
                                    }
                            },
                        title:
                            {
                                text: 'Number of Dead Clients Disaggregated by Age and Sex'
                            },
                        //colors: colors,
                        colors: ['#4527a0', '#9575cd'],
                        xAxis: [{
                            categories: categories,
                            reversed: false,
                            labels:
                                {
                                    step: 1
                                },
                            accessibility:
                                {
                                    description: 'Age (male)'
                                }
                        }, { // mirror axis on right side
                            opposite: true,
                            reversed: false,
                            categories: categories,
                            linkedTo: 0,
                            labels: {
                                step: 1
                            },
                            accessibility:
                                {
                                    description: 'Age (female)'
                                }
                        }],
                        yAxis:
                            { // Primary yAxis
                                gridLineWidth: 0,
                                minorGridLineWidth: 0,
                                labels:
                                    {
                                        formatter() {
                                            return Math.abs(this.value)
                                        }
                                    },
                                title: {
                                    text: 'Total Deaths',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                }
                            },
                        tooltip:
                            {
                                headerFormat: `<span style="font-size:10px; font-weight: bold">{point.key} years</span><table>`,
                                pointFormatter: function () {
                                    return '<tr><td style="color:' + this.series.color + ';padding:0">' + this.series.name + ': </td>' +
                                        '<td style="padding:0"><b>' + Math.abs(this.y) + '<b></td></tr>'
                                },
                                footerFormat: `</table>`,
                                shared: true,
                                useHTML: true
                            },
                        series: deathsByAgeAndSexSeries
                    });
                Highcharts.chart('msArtDurationState',
                    {
                        chart:
                            {
                                type: 'column'
                            },
                        plotOptions:
                            {
                                column:
                                    {
                                        stacking: 'percent',
                                        dataLabels:
                                            {
                                                enabled: true
                                            },
                                        pointPadding: 0,
                                        borderWidth: 0
                                    }
                            },
                        title:
                            {
                                text: 'Number of Dead Clients Disaggregated by Duration on ART'
                            },
                        colors: ['#ff9e80', '#ff5722', '#ff9800', '#607d8b', '#64b5f6', '#1565c0'], //, '#bbdefb', '#0d47a1'
                        xAxis:
                            {
                                title:
                                    {
                                        useHTML: true
                                    },
                                type: "category",
                                //categories: protocolNames,
                                labels:
                                    {
                                        useHTML: true,
                                        //rotation:90
                                    }
                            },
                        yAxis:
                            { // Primary yAxis
                                gridLineWidth: 0,
                                minorGridLineWidth: 0,
                                labels: {
                                    format: '{value}',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                },
                                title: {
                                    text: 'Total Deaths',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                }
                            },
                        tooltip:
                            {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y} <b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                        series: artDurationSeries
                    });
                Highcharts.chart('msVlPie',
                    {
                        chart:
                            {
                                type: 'pie'
                            },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions:
                            {
                                pie:
                                    {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>:<br>{point.y} ({point.percentage:.1f}%)'
                                        },
                                        showInLegend: true
                                    }
                            },
                        title:
                            {
                                text: 'Dead Clients Disaggregated by Last Viral Load Status'
                            },
                        colors: ['#3b5998', '#0d47a1', '#607d8b', '#64b5f6', '#1565c0'],
                        tooltip:
                            {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y} ({point.percentage:.1f}%) <b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                        series:
                            [
                                {
                                    name: 'Death rates by Viral Load Status',
                                    colorByPoint: true,
                                    innerSize: '60%',
                                    data:
                                        [{name: 'Suppressed', y: ttSuppressed},
                                            {name: 'Unsuppressed', y: ttUnsuppressed},
                                            {name: 'No Viral Load', y: ttNoViralLoadResult}]
                                }
                            ]
                    });
                Highcharts.chart('msRegs',
                    {
                        chart:
                            {
                                type: 'column'
                            },
                        plotOptions:
                            {
                                column:
                                    {
                                        pointPadding: 0,
                                        borderWidth: 0
                                    }
                            },
                        title:
                            {
                                text: 'Number of Dead Clients by Last Regimen Line'
                            },
                        colors: ['rgb(74,20,140)', '#607d8b', '#64b5f6', '#7b1fa2', '#1565c0', '#3b5998', '#0d47a1', '#607d8b'],
                        xAxis:
                            {
                                title:
                                    {
                                        useHTML: true
                                    },
                                type: "category",
                                //categories: protocolNames,
                                labels:
                                    {
                                        useHTML: true,
                                        //rotation:90
                                    }
                            },
                        yAxis:
                            { // Primary yAxis
                                gridLineWidth: 0,
                                minorGridLineWidth: 0,
                                labels: {
                                    format: '{value}',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                },
                                title: {
                                    text: 'Total Deaths',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                }
                            },
                        tooltip:
                            {
                                headerFormat: '<span style="font-size:13px; font-weight: bold">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{point.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y} <b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                        series: [{name: 'Deaths by Regimen Line', data: rgLines}]
                    });
                //State map
                (async () => {
                    const topology = await fetch(
                        'https://code.highcharts.com/mapdata/countries/ng/ng-all.topo.json'
                    ).then(response => response.json());

                    // Prepare State data. The data is joined to map using value of 'hc-key'
                    // property by default. See API docs for 'joinBy' for more info on linking
                    // data and map.
                    const mapData = [];

                    stateDeaths.map(function fp(s) {
                        let nm = s.name.toLowerCase();
                        let nmFound = false;
                        if (nm === 'kaduna') {
                            mapData.push(['ng-kd', s.y]);
                            nmFound = true;
                        }
                        if (nm === 'bayelsa') {
                            mapData.push(['ng-by', s.y]);
                            nmFound = true;
                        }
                        if (nm === 'katsina') {
                            mapData.push(['ng-kt', s.y]);
                            nmFound = true;
                        }
                        if (nm === 'kano') {
                            mapData.push(['ng-kn', s.y]);
                            nmFound = true;
                        }
                        if (!nmFound) {
                            let nmSub = 'ng-' + nm.substring(0, 2);
                            mapData.push([nmSub, s.y]);
                            nmFound = true;
                        }
                    });

                    // Create the chart
                    Highcharts.mapChart('msMap',
                        {
                            chart: {
                                map: topology
                            },

                            title: {
                                text: 'Mortality Distribution'
                            },

                            subtitle: {
                                text: 'Source map: <a href="http://code.highcharts.com/mapdata/countries/ng/ng-all.topo.json">Nigeria</a>'
                            },

                            mapNavigation: {
                                enabled: true,
                                buttonOptions: {
                                    verticalAlign: 'bottom'
                                }
                            },

                            colorAxis: {
                                min: 0
                            },

                            series: [{
                                data: mapData,
                                name: 'Total Deaths',
                                states: {
                                    hover: {
                                        color: '#BADA55'
                                    }
                                },
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}'
                                }
                            }]
                        });

                })();

            }*/

            Array.prototype.sumX = function (prop1, prop2, prop3, prop4)
            {
                var total = 0
                for ( var i = 0, _len = this.length; i < _len; i++ )
                {
                    total += (this[i][prop1] + this[i][prop2] + this[i][prop3] + this[i][prop4]);
                }
                return total
            }

            function buildMsDrilldownChart(data) {
                let years = [];
                let drillDowns = [];
                let trends = [];
                let drilldownTrends = [];

                let totalYears = data.sumX('q1', 'q2', 'q3', 'q4');

                data.sort((a, b) => a.year - b.year);

                let colors = ['#B7B8BC', '#6bafa7', '#93911b', '#33691e', '#85D1C1', '#CAC99A', '#494FA3', '#ED745F', '#615D8B', '#959335', '#CAC99A', '#d35e13',
                    '#dbc79d', '#003056', '#7ea8ad', '#acc37e', '#0a5d66', '#f7a800', '#b8a999', '#d2ddbb', '#706259'];

                data.forEach(function (qm, i) {
                    let q1D = [];
                    let q2D = [];
                    let q3D = [];
                    let q4D = [];
                    let qs = [];

                    q1D.push({name: 'January', y: qm.january, color: colors[i]});
                    q1D.push({name: 'February', y: qm.february, color: colors[i + 1]});
                    q1D.push({name: 'March', y: qm.march, color: colors[i + 2]});
                    q2D.push({name: 'April', y: qm.april, color: colors[i + 3]});
                    q2D.push({name: 'May', y: qm.may, color: colors[i + 4]});
                    q2D.push({name: 'June', y: qm.june, color: colors[i + 5]});
                    q3D.push({name: 'July', y: qm.july, color: colors[i + 6]});
                    q3D.push({name: 'August', y: qm.august, color: colors[i + 7]});
                    q3D.push({name: 'September', y: qm.september, color: colors[i + 8]});
                    q4D.push({name: 'October', y: qm.october, color: colors[i + 9]});
                    q4D.push({name: 'November', y: qm.november, color: colors[i + 10]});
                    q4D.push({name: 'December', y: qm.december, color: colors[i + 11]});


                    //--------------------------------------------------------------------------------------------

                    //--- Q1 --------
                    let yrJan = (qm.january / qm.q1) * 100;
                    let yrFeb = (qm.february / qm.q1) * 100;
                    let yrMarch = (qm.january / qm.q1) * 100;

                    let q1Rates = [];
                    q1Rates.push({name: 'January Death Rate', y: yrJan});
                    q1Rates.push({name: 'February Death Rate', y: yrFeb});
                    q1Rates.push({name: 'March Death Rate', y: yrMarch});

                    //--- Q2 --------
                    let yrApril = (qm.april / qm.q2) * 100;
                    let yrMay = (qm.may / qm.q2) * 100;
                    let yrJune = (qm.june / qm.q2) * 100;

                    let q2Rates = [];
                    q2Rates.push({name: 'April Death Rate', y: yrApril});
                    q2Rates.push({name: 'May Death Rate', y: yrMay});
                    q2Rates.push({name: 'June Death Rate', y: yrJune});

                    //--- Q3 --------
                    let yrJuly = (qm.july / qm.q3) * 100;
                    let yrAug = (qm.august / qm.q3) * 100;
                    let yrSept = (qm.september / qm.q3) * 100;

                    let q3Rates = [];
                    q3Rates.push({name: 'July Death Rate', y: yrJuly});
                    q3Rates.push({name: 'August Death Rate', y: yrAug});
                    q3Rates.push({name: 'September Death Rate', y: yrSept});

                    //--- Q4 --------
                    let yrOct = (qm.october / qm.q4) * 100;
                    let yrNov = (qm.november / qm.q4) * 100;
                    let yrDec = (qm.december / qm.q4) * 100;

                    let q4Rates = [];
                    q4Rates.push({name: 'October Death Rate', y: yrOct});
                    q4Rates.push({name: 'November Death Rate', y: yrNov});
                    q4Rates.push({name: 'December Death Rate', y: yrDec});

                    //----------------------------------

                    let tDTT = qm.q1 + qm.q2 + qm.q3 + qm.q4;
                    let q1rate = (qm.q1 / tDTT) * 100;
                    let q2rate = (qm.q2 / tDTT) * 100;
                    let q3rate = (qm.q3 / tDTT) * 100;
                    let q4rate = (qm.q4 / tDTT) * 100;

                    drillDowns.push({name: 'Q1', data: q1D, id: qm.year + 'Q1', type: 'column'});
                    drilldownTrends.push({
                        name: 'Q1-Rate',
                        data: q1Rates,
                        type: 'scatter',
                        id: qm.year + 'Q1-Rate',
                        yAxis: 1,
                        marker: {lineWidth: 2, lineColor: 'orange', fillColor: 'white'},
                        ref: qm.year + 'Q1'
                    });

                    drillDowns.push({name: 'Q2', data: q2D, id: qm.year + 'Q2', type: 'column'});
                    drilldownTrends.push({
                        name: 'Q2-Rate',
                        data: q2Rates,
                        type: 'scatter',
                        id: qm.year + 'Q2-Rate',
                        yAxis: 1,
                        marker: {lineWidth: 2, lineColor: 'orange', fillColor: 'white'},
                        ref: qm.year + 'Q2'
                    });

                    drillDowns.push({name: 'Q3', data: q3D, id: qm.year + 'Q3', type: 'column'});
                    drilldownTrends.push({
                        name: 'Q3-Rate',
                        data: q3Rates,
                        type: 'scatter',
                        id: qm.year + 'Q3-Rate',
                        yAxis: 1,
                        marker: {lineWidth: 2, lineColor: 'orange', fillColor: 'white'},
                        ref: qm.year + 'Q3'
                    });

                    drillDowns.push({name: 'Q4', data: q4D, id: qm.year + 'Q4', type: 'column'});
                    drilldownTrends.push({
                        name: 'Q4-Rate',
                        data: q4Rates,
                        type: 'scatter',
                        id: qm.year + 'Q4-Rate',
                        yAxis: 1,
                        marker: {lineWidth: 2, lineColor: 'orange', fillColor: 'white'},
                        ref: qm.year + 'Q4'
                    });

                    qs.push({name: 'Q1', y: qm.q1, drilldown: qm.year + 'Q1', color: colors[i]});
                    qs.push({name: 'Q2', y: qm.q2, drilldown: qm.year + 'Q2', color: colors[i + 1]});
                    qs.push({name: 'Q3', y: qm.q3, drilldown: qm.year + 'Q3', color: colors[i + 2]});
                    qs.push({name: 'Q4', y: qm.q4, drilldown: qm.year + 'Q4', color: colors[i + 3]});


                    let qRates = [];
                    qRates.push({name: qm.year, y: q1rate, drilldown: qm.year + 'Q1R'});
                    qRates.push({name: qm.year, y: q2rate, drilldown: qm.year + 'Q2R'});
                    qRates.push({name: qm.year, y: q3rate, drilldown: qm.year + 'Q3R'});
                    qRates.push({name: qm.year, y: q4rate, drilldown: qm.year + 'Q4R'});

                    drillDowns.push({name: qm.year.toString(), data: qs, type: 'column', id: qm.year + 'Qs'});

                    drilldownTrends.push({
                        name: qm.year.toString(),
                        data: qRates,
                        type: 'scatter',
                        id: qm.year + 'QR',
                        yAxis: 1,
                        marker: {lineWidth: 2, lineColor: 'orange', fillColor: 'white'},
                        ref: qm.year + 'Qs'
                    });

                    years.push({name: qm.year.toString(), y: tDTT, drilldown: qm.year + 'Qs', color: colors[i]});

                    let yRate = ((tDTT / totalYears) * 100);
                    trends.push({name: qm.year.toString(), y: yRate, drilldown: qm.year + 'QR'});

                });

                let dwQ = [{name: 'Death Toll', data: years, type: 'column', showInLegend: false}
                    //,  { type: 'spline', name: 'Trend', data: trends, yAxis: 1,  marker: { lineWidth: 2, lineColor: 'orange', fillColor: 'white' } }
                ];

                var chart = Highcharts.chart('msDrillDown',
                    {
                        chart:
                            {
                                type: 'column'
                            },
                        plotOptions:
                            {
                                column:
                                    {
                                        pointPadding: 0,
                                        borderWidth: 0
                                    }
                            },
                        title:
                            {
                                text: 'Mortality data across selected calendar year (s)'
                            },
                        xAxis:
                            {
                                title:
                                    {
                                        useHTML: true
                                    },
                                type: "category",
                                //categories: protocolNames,
                                labels:
                                    {
                                        useHTML: true,
                                        //rotation:90
                                    }
                            },
                        yAxis:
                            [{ // Primary yAxis
                                gridLineWidth: 0,
                                minorGridLineWidth: 0,
                                labels: {
                                    format: '{value}',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                },
                                title: {
                                    text: 'Mortality Data ',
                                    style: {
                                        color: Highcharts.getOptions().colors[1]
                                    }
                                }
                            },
                                { // Secondary yAxis
                                    title:
                                        {
                                            text: '% Dead',
                                            rotation: 270,
                                            style: {
                                                color: Highcharts.getOptions().colors[0]
                                            }
                                        },
                                    gridLineWidth: 0,
                                    minorGridLineWidth: 0,
                                    min: 0,
                                    max: 100,
                                    labels: {
                                        format: '{value}',
                                        style: {
                                            color: Highcharts.getOptions().colors[0]
                                        }
                                    },
                                    opposite: true,
                                    showFirstLabel: true,
                                    showLastLabel: false
                                }
                            ],
                        tooltip:
                            {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{point.color};padding:0">Number of Deaths: </td>' +
                                    '<td style="padding:0"><b>{point.y} <b></td></tr>',
                                footerFormat: '</table>',
                                //shared: true,
                                useHTML: true
                            },
                        series: dwQ,
                        drilldown:
                            {
                                series: drillDowns
                            },
                        responsive:
                            {
                                rules: [{
                                    condition: {
                                        maxWidth: 500
                                    },
                                    chartOptions: {
                                        legend: {
                                            align: 'center',
                                            verticalAlign: 'bottom',
                                            layout: 'horizontal'
                                        },
                                        yAxis: {
                                            labels: {
                                                align: 'left',
                                                x: 0,
                                                y: -5
                                            },
                                            title: {
                                                text: null
                                            }
                                        },
                                        subtitle: {
                                            text: null
                                        },
                                        credits: {
                                            enabled: false
                                        }
                                    }
                                }]
                            }
                    });
            }

                function groupArrayByKey(array, key) {
                    return array.reduce((hash, obj) => {
                        if (obj[key] === undefined) return hash;
                        return Object.assign(hash, {[obj[key]]: (hash[obj[key]] || []).concat(obj)})
                    }, {});
                }
        </script>
    @endsection
</x-app-layout>

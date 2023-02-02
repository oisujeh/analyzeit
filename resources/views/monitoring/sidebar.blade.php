<div class="col-span-3 bg-white rounded p-4 drop-shadow-md">
    <p class="text-sm font-medium">APPLY FILTERS BELOW TO LOAD DATA</p>

    <!--begin::Form-->
    <form class="" name="filterForm" id="filters" method="POST">


        <div class="col-span-6 sm:col-span-3">
            <label for="directorate" class="block text-sm text-gray-500 mt-3">
                <i class="uil uil-list-ul"></i> Select MER Indicator
            </label>

            <select id="selectIndicator" name="selectIndicator" class="select2 mt-1 block w-full py-2 px-3
                                border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500
                                focus:border-indigo-500 sm:text-sm" onchange="updateSelectedIndicator(this.value)">
                <option value="" disabled selected hidden>Choose ...</option>
                <option value="tx_new">Treatment New</option>
                <option value="tx_curr">Treatment Current</option>
                <option value="tx_pvls">Treatment PVLS</option>
            </select>
        </div>

        <!-- States -->
        <div class="col-span-6 sm:col-span-3">
            <label for="state" class="block text-sm text-gray-500 mt-5">
                <i class="uil uil-map-pin-alt"></i> States
            </label>
            <select id="state" name="state" class="e2 select2 select2-selection--multiple mt-1 block w-full py-1 px-1.5 border border-gray-300 bg-white
            rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" data-toggle="select2" multiple="multiple">
                <option value="">Choose ...</option>
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
            <select id="lga" name="lga" class="e2 select2 mt-1 block w-full h-4 py-2 px-3 border
            border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500
            focus:border-indigo-500 sm:text-sm" data-toggle="select2" multiple="multiple">
                <option value="">Choose ...</option>

            </select>
        </div>

        <div class="col-span-6 sm:col-span-3">
            <label for="facility" class="block text-sm text-gray-500 mt-5">
                <i class="uil uil-box"></i> Facilities
            </label>
            <select id="facility" name="facility" class="e2 select2 select2-selection--multiple mt-1 block w-full py-2 px-3 border
            border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500
            focus:border-indigo-500 sm:text-sm" data-toggle="select2" multiple="multiple">

            </select>
        </div>


        <div id="div1">
            <div class="col-span-6 sm:col-span-3 mt-5">
                <label for="cat" class="block text-sm text-gray-500">
                    <i class="uil uil-schedule"></i> From Date
                </label>
                <input type="date" name="from" id="cat1" class="mt-1 focus:ring-indigo-500
                 w-full shadow-sm sm:text-sm border-gray-300
                rounded-md"/>
            </div>

            <div class="col-span-6 sm:col-span-3 mt-5 ">
                <label for="cat" class="block text-sm text-gray-500">
                    <i class="uil uil-schedule"></i> To Date
                </label>
                <input type="date" name="to" id="cat2" class="mt-1 focus:ring-indigo-500
                block w-full shadow-sm sm:text-sm border-gray-300
                rounded-md"/>
            </div>
        </div>


        <div class="col-span-6 sm:col-span-3 mt-5 text-left">
            <button class="inline-flex justify-center py-2 px-4
            border border-transparent shadow-sm text-sm font-bold rounded-md
            text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none
            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Load Data
            </button>

            <button type="submit" class="inline-flex justify-center py-2 px-4
             border border-transparent shadow-sm text-sm font-bold rounded-md
             text-white bg-gray-500 hover:bg-gray-700 focus:ring-2 focus:ring-offset-2
             focus:ring-indigo-500">Clear
            </button>
        </div>
    </form>
    <!--end::Form-->
</div>

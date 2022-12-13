<div class="col-span-3 bg-white rounded p-4 drop-shadow-md">
    <p class="text-sm font-medium">APPLY FILTERS BELOW TO LOAD DATA</p>

    <div class="col-span-6 sm:col-span-3">
        <label for="directorate" class="block text-sm text-gray-500 mt-3">
            <i class="uil uil-list-ul"></i> Select MER Indicator
        </label>
        <select id="directorate" name="directorate_id" class="select2 mt-1 block w-full py-2 px-3
                            border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500
                            focus:border-indigo-500 sm:text-sm" required>
            <option value="" disabled selected hidden>Choose Directorate</option>
            <option value="1">Treatment New</option>
            <option value="1">Treatment Current</option>
            <option value="1">Treatment PVLS</option>
        </select>
    </div>

    <div class="col-span-6 sm:col-span-3">
        <label for="directorate" class="block text-sm text-gray-500 mt-5">
            <i class="uil uil-map-pin-alt"></i> States
        </label>
        <select id="directorate" name="directorate_id" class="select2 mt-1 block w-full py-2 px-3
                            border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500
                            focus:border-indigo-500 sm:text-sm" required>
            <option value="" disabled selected hidden>Choose Directorate</option>
            <option value="1">Treatment New</option>
            <option value="1">Treatment Current</option>
            <option value="1">Treatment PVLS</option>
        </select>
    </div>

    <div class="col-span-6 sm:col-span-3">
        <label for="directorate" class="block text-sm text-gray-500 mt-5">
            <i class="uil uil-map-pin-alt"></i> LGAs
        </label>
        <select id="directorate" name="directorate_id" class="select2 mt-1 block w-full py-2 px-3 border
                            border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            <option value="" disabled selected hidden>Choose Directorate</option>
            <option value="1">Treatment New</option>
            <option value="1">Treatment Current</option>
            <option value="1">Treatment PVLS</option>
        </select>
    </div>

    <div class="col-span-6 sm:col-span-3">
        <label for="directorate" class="block text-sm text-gray-500 mt-5">
            <i class="uil uil-box"></i> Facilities
        </label>
        <select id="directorate" name="directorate_id" class="select2 mt-1 block w-full py-2 px-3 border
                            border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            <option value="" disabled selected hidden>Choose Directorate</option>
            <option value="1">Treatment New</option>
            <option value="1">Treatment Current</option>
            <option value="1">Treatment PVLS</option>
        </select>
    </div>

    <div class="col-span-6 sm:col-span-3 mt-5">
        <label for="cat" class="block text-sm text-gray-500">
            <i class="uil uil-schedule"></i> From Date
        </label>
        <input type="date" name="category" id="cat" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block
                            w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required placeholder="Category of Health Workers">
    </div>

    <div class="col-span-6 sm:col-span-3 mt-5">
        <label for="cat" class="block text-sm text-gray-500">
            <i class="uil uil-schedule"></i> To Date
        </label>
        <input type="date" name="category" id="cat" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500
                            block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required placeholder="Category of Health Workers">
    </div>

    <div class="col-span-6 sm:col-span-3 mt-5 text-left">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent
                            shadow-sm text-sm font-bold rounded-md text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Load Data
        </button>

        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent
                            shadow-sm text-sm font-bold rounded-md text-white bg-gray-500 hover:bg-gray-700
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Clear
        </button>
    </div>
</div>

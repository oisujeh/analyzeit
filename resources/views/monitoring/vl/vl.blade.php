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
        <div class="box-heading ml-4 mt-2 font-bold text-sm">
            Key Metric Viral Load Cascade
        </div>
        <div class="absolute top-0 right-0 mt-1 data-te-dropdown-ref">
            <div>
                <div class="relative" data-te-dropdown-ref>
                    <a class="pt-1 text-xs mr-2"
                       href="#"
                       type="button"
                       id="dropdownMenuButton2"
                       data-te-dropdown-toggle-ref
                       aria-expanded="false"
                       data-te-ripple-init
                       data-te-ripple-color="light">
                        <i class="uil uil-bars"></i>
                    </a>
                    <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg
                        border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700
                        [&[data-te-dropdown-show]]:block" aria-labelledby="dropdownMenuButton2" data-te-dropdown-menu-ref>
                        <li>
                            <a class="block w-full whitespace-nowrap py-2 px-4 text-sm font-normal
                                bg-white text-neutral-700 hover:bg-neutral-100 active:text-neutral-800
                                active:no-underline disabled:pointer-events-none disabled:bg-transparent
                                disabled:text-neutral-400" href="#" onclick="downloadPng('ageSexChart')"
                               data-te-dropdown-item-ref>Download PNG
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="box-content">
            <div class="chart" id="VL_Cascade_KeyMetric"></div>
        </div>
    </div>
</div>


<div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
    <div class="col-span-1 bg-white drop-shadow-md relative">
        <div class="box-heading ml-4 mt-2 font-bold text-sm">
            Viral Load Coverage
        </div>
        <div class="absolute top-0 right-0 mt-1 data-te-dropdown-ref" >
            <div>
                <div class="relative" data-te-dropdown-position="dropstart">
                    <a class="pt-1 text-xs mr-2"
                       href="#"
                       type="button"
                       id="dropdownMenuButton2"
                       data-te-dropdown-toggle-ref
                       aria-expanded="false"
                       data-te-ripple-init
                       data-te-ripple-color="light">
                        <i class="uil uil-bars"></i>
                    </a>
                    <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden
                        rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg
                        dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                        aria-labelledby="dropdownMenuButton2" data-te-dropdown-menu-ref>
                        <li>
                            <a class="block w-full whitespace-nowrap py-2 px-4 text-sm font-normal bg-white text-neutral-700
                                hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none
                                disabled:bg-transparent disabled:text-neutral-400" href="#" onclick="downloadPng('sexChart')"
                               data-te-dropdown-item-ref>Download PNG
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="box-content">
            <div class="chart" id="viral_Load_Coverage">
            </div>
        </div>
    </div>

    <div class="col-span-1 bg-white drop-shadow-md relative">
        <div class="box-heading ml-4 mt-2 font-bold text-sm">
            Viral Load Suppression
        </div>
        <div class="absolute top-0 right-0 mt-1 data-te-dropdown-ref" >
            <div>
                <div class="relative" data-te-dropdown-position="dropend">
                    <a class="pt-1 text-xs mr-2"
                       href="#"
                       type="button"
                       id="dropdownMenuButton2"
                       data-te-dropdown-toggle-ref
                       aria-expanded="false"
                       data-te-ripple-init
                       data-te-ripple-color="light">
                        <i class="uil uil-bars"></i>
                    </a>
                    <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg
                        border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700
                        [&[data-te-dropdown-show]]:block" aria-labelledby="dropdownMenuButton2" data-te-dropdown-menu-ref>
                        <li>
                            <a class="block w-full whitespace-nowrap py-2 px-4 text-sm font-normal
                                bg-white text-neutral-700 hover:bg-neutral-100 active:text-neutral-800
                                active:no-underline disabled:pointer-events-none disabled:bg-transparent
                                disabled:text-neutral-400" href="#" onclick="downloadPng('ageChart')"
                               data-te-dropdown-item-ref>Download PNG</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="box-content">
            <div class="chart" id="viral_Load_Suppression">
            </div>
        </div>
    </div>
</div>



<div class="grid grid-cols-1 mt-6">
    <div class="col-span-1 bg-white drop-shadow-md relative">
        <div class="box-heading ml-2 mt-2 font-bold text-sm">
            Viral Load Coverage By State
        </div>
        <div class="box-content">
            <div class="chart" id="vlComparativeViewByIP">
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 mt-6">
    <div class="col-span-1 bg-white drop-shadow-md relative">
        <div class="box-heading ml-2 mt-2 font-bold text-sm">
            Viral Load Suppression By State
        </div>
        <div class="box-content">
            <div class="chart" id="vlSuppressionComparativeViewByIP">
            </div>
        </div>
    </div>
</div>



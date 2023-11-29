<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Line List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4">

                <!--Start side bar -->
                <div class="col-span-12 bg-white h-fit rounded p-4 drop-shadow-md">
                    <div class="col-span-9">
                        <h2>@{{progress}}</h2>
                        <hr>
                        <h5>@{{pageTitle}}</h5>
                        <hr>

                        <div class="progress mt-4">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 :aria-valuenow="progressPercentage"
                                 aria-valuemin="0"
                                 aria-valuemax="100"
                                 :style="`width: ${progressPercentage}%;`">
                                @{{progressPercentage}}%
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('footer_scripts')
<!--        <script src="https://unpkg.com/vue@3.2.47/dist/vue.global.prod.js"></script>-->
        <script src="https://unpkg.com/vue@3"></script>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <script type="text/javascript">
            const app = Vue.createApp({
                data() {
                    return {
                        progress: 'Welcome to progress page',
                        pageTitle: 'Progress of Uploads',
                        progressPercentage: 0,
                        params: {
                            id: null
                        }
                    }
                },
                methods: {
                    checkIfIdPresent() {
                        const urlSearchParams = new URLSearchParams(window.location.search);
                        const params = Object.fromEntries(urlSearchParams.entries());

                        if (params.id) {
                            this.params.id = params.id;
                        }
                    },
                    async getUploadProgress() {
                        try {
                            this.checkIfIdPresent();

                            //Get progress data
                            const response = await axios.get("/progress/data", {
                                params: {
                                    id: this.params.id || "{{session()->get('lastBatchId')}}",
                                }
                            });

                            console.log(response.data);

                            let totalJobs = parseInt(response.data.total_jobs);
                            let pendingJobs = parseInt(response.data.pending_jobs);
                            let completedJobs = totalJobs - pendingJobs;

                            if (pendingJobs == 0) {
                                this.progressPercentage = 100;
                            } else {
                                this.progressPercentage = parseInt(completedJobs / totalJobs * 100).toFixed(0);
                            }

                            if (parseInt(this.progressPercentage) >= 100) {
                                clearInterval(this.progressResponse)
                            }
                        } catch (error) {
                            console.error(error);
                        }
                    }
                },
                created() {
                    this.checkIfIdPresent();
                    this.progressResponse = setInterval(() => {
                        this.getUploadProgress();
                    }, 1000);
                }
            });

            app.mount("#app");


        </script>


    @endsection
</x-app-layout>

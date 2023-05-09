<?php

namespace App\Jobs;

use App\Models\Patient;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLineList implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $patientData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($patientData)
    {
        $this->patientData = $patientData;
        //dd($this->patientData );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->patientData as $patientData)
        {
            $patient = new Patient();
            $patient->IP = $patientData['IP'];
            $patient->save();


        }
    }
}

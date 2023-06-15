<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLineList;
use App\Models\JobBatch;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UploadController
{
    public function index(): Factory|View|Application
    {
        return view('upload');
    }


    public function progress(): Factory|View|Application
    {
        return view('progress');
    }

    public function uploadFile(Request $request)
    {
        try
        {
            if($request->has('csvFile'))
            {

                $fileName = $request->csvFile->getClientOriginalName();
                $fileWithPath = public_path('uploads').'/'.$fileName;
                if(!file_exists($fileWithPath))
                {
                    $request->csvFile->move(public_path('uploads'), $fileName);
                }

                $header = null;
                $dataFromcsv = array();
                $records = array_map('str_getcsv', file($fileWithPath));

                //Rearranging the records
                foreach($records as $record)
                {
                    if(!$header)
                    {
                        $header = $record;
                    }else{
                        $dataFromcsv[] = $record;
                    }
                }

                //Chunking the data
                $dataFromcsv = array_chunk($dataFromcsv,300);
                $batch = Bus::batch([])->dispatch();

                //Looping through each chunk
                foreach($dataFromcsv as $index => $dataCsv)
                {
                    //Loop through each patient record
                    foreach($dataCsv as $data)
                    {
                        $patientData[$index][] = array_combine($header,$data);
                    }
                    $batch->add(new ProcessLineList($patientData[$index]));
                    //ProcessLineList::dispatch($patientData[$index]);
                }

                //Update session id every time batch is processed
                session()->put('lastBatchId',$batch->id);

                return redirect('/progress?id='.$batch->id);
            }
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function progressUpload(Request $request){
        try {
            $batchId = $request->id ?? session()->get('lastBatchId');

            if(JobBatch::where('id',$batchId)->count())
            {
                $response = JobBatch::where('id',$batchId)->first();
                return response()->json($response);
            }
        }catch (Exception $e){
            Log::error($e);
            dd($e);
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
        }
    }

}

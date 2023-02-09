<?php

namespace App\Console\Commands;

use App\Models\AppointmentHistoryLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\StreamInterface;

class SMSWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms-week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler to send SMS for patients 7 days to appointment date';

    /**
     * Execute the console command.
     *
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function handle(): StreamInterface
    {
        $appointment = DB::table('next_day_appointments')
            ->where(['status'=>0])
            ->whereBetween('next_appointment', [Carbon::today()->toDate(), Carbon::today()->addDays(7)->toDate()])
            ->whereNotNull('phone_no')->get();


        $sent = [];
        $res = "";
        $ids = [];

        foreach ($appointment as $key => $value){
            $ids[$key]['id'] = $value->id;
            $ids[$key]['State'] = $value->state;
            $ids[$key]['LGA'] = $value->lga;
            $ids[$key]['Datim_Code'] = $value->datim_code;
            $ids[$key]['status'] = 1;
            $sent[$key]['PepId'] = $value->pepid;
            $sent[$key]['VisitDate'] = $value->next_appointment;
            $sent[$key]['PhoneNumber'] = $value->phone_no;
            $sent[$key]['AppointmentDate'] = $value->next_appointment;
            $sent[$key]['AppointmentOffice'] = 'P';
            $sent[$key]['AppointmentData'] = array('DrugToCollect'=>"AZT/3TC/NVP",'NextApptDate'=> $value->next_appointment);
        }

        /*dd(json_encode($sent,JSON_UNESCAPED_SLASHES));*/

        $client = new Client([
            'verify' => base_path('public/cacert.pem')
        ]);

        $response = $client->post('https://pbs.apin.org.ng/Integration/MessageDeliveryRequest/PushNextAppointment',[
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($sent,JSON_UNESCAPED_SLASHES)
        ]);

        $res = $response->getBody();

        foreach($ids as $key => $id){
            DB::table('next_day_appointments')
                ->where('id',$id)
                ->update(['status' => 1]);

            $appointmentHistoryLog = new AppointmentHistoryLog();
            $appointmentHistoryLog->state = $id['State'];
            $appointmentHistoryLog->lga = $id['LGA'];
            $appointmentHistoryLog->datim_code = $id['Datim_Code'];
            $appointmentHistoryLog->pepid = $sent[$key]['PepID'];
            $appointmentHistoryLog->phone_no = $sent[$key]['PhoneNUmber'];
            $appointmentHistoryLog->status = 1;
            $appointmentHistoryLog->save();
        }

        return $res;
    }
}

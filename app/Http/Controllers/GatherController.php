<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Twilio\Twiml;
use Twilio\Rest\Client;
use App\Models\TwilioNumbers;
use Illuminate\Support\Facades\Log;
use App\Models\TwilioCallLists;
use App\Models\TwilioCalls;
use App\Services\AllGatherService;

class GatherController extends Controller
{
    protected $allGatherService;
    public function __construct(AllGatherService $allGatherService) {

        $this->account_sid = env("TWILIO_SID");
        $this->auth_token = env("TWILIO_AUTH_TOKEN");

        $this->from = env("TWILIO_NUMBER");


        $this->client = new Client($this->account_sid, $this->auth_token);

        $this->allGatherService = $allGatherService;
    }
    public function callFun(Request $request,$id)
    {

      $response = new VoiceResponse();

if (array_key_exists('Digits', $_POST)) {
        Log::info('ss',$_POST);
    switch ($_POST['Digits']) {
    case 1:
        $response->say('You selected to take the survey. Thank you!');
        TwilioCallLists::where('phone_num',$_POST['To'])->update(array('call_status' => 1,'emp_resp' => 1,'award_shift' => 1));
        
        break;
    case 2:
        $response->say('You selected to her a joke! Why did the robot cross the road? Because it was carbon bonded to the chicken!');
        TwilioCallLists::where('phone_num',$_POST['To'])->update(array('call_status' => 1,'emp_resp' => 2));
        
          $this->allGatherService->callGather($id);
        
        break;
    default:
        $response->say('Sorry, I don\'t understand that choice.');
        
    }
}

header('Content-Type: text/xml');
echo $response;
    }

    public function callDropGet(Request $request,$id)
    {
        $fullReq = $request->all();
        // Log::info($fullReq);
        if ($fullReq) {
        $timestamp = $fullReq['Timestamp'];
         $middle = strtotime($timestamp); 
         $dateTime = date('Y-m-d H:i:s', $middle);
            switch ($fullReq) {
                case $fullReq['CallStatus'] == 'no-answer' :
                    TwilioCallLists::where('phone_num',$fullReq['To'])->update(array('call_status' => 1,'CallTime' => $dateTime,'emp_resp' => 3));
                    $this->allGatherService->callGather($id);
                    break;

                    case $fullReq['CallStatus'] == 'busy' :
                    TwilioCallLists::where('phone_num',$fullReq['To'])->update(array('call_status' => 1,'CallTime' => $dateTime,'emp_resp' => 4));
                    $this->allGatherService->callGather($id);
                    break;

                    case $fullReq['CallStatus'] == 'completed' :
                    $twilioNumberss = TwilioCallLists::where(['call_status' => 0,'phone_num' => $fullReq['To']])->orderBy('order_num', 'ASC')->with('country')->first();
                    if ($twilioNumberss) {
                            TwilioCallLists::where('phone_num',$fullReq['To'])->update(array('call_status' => 1,'emp_resp' => 3));
                            $this->allGatherService->callGather($id);
                        
                    }

                    $twilioCallStatus = TwilioCallLists::where(['call_status' => 1,'phone_num' => $fullReq['To']])->orderBy('order_num', 'ASC')->with('country')->first();
                    if ($twilioCallStatus) {
                        TwilioCallLists::where('phone_num',$fullReq['To'])->update(array('CallTime' => $dateTime));
                    }
                    break;

                    case $fullReq['AnsweredBy'] == 'null' :
                    TwilioCallLists::where('phone_num',$fullReq['To'])->update(array('call_status' => 1,'CallTime' => $dateTime,'emp_resp' => 4));
                    $this->allGatherService->callGather($id);
                    break;
            }
            
        }
    }
}
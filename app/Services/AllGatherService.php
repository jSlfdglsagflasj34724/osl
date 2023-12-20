<?php
namespace App\Services;
use App\User;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Twilio\Twiml;
use Twilio\Rest\Client;
use App\Models\TwilioNumbers;
use Illuminate\Support\Facades\Log;
use App\Models\TwilioCallLists;
use App\Models\TwilioCalls;

class AllGatherService {
    

    public function __construct()
    {
        $this->account_sid = env("TWILIO_SID");
        $this->auth_token = env("TWILIO_AUTH_TOKEN");
        $this->from = env("TWILIO_NUMBER");
        $this->client = new Client($this->account_sid, $this->auth_token);
    }

    public function callGather($id)
    {
        $twilioNumbers = TwilioCallLists::where(['call_status' => 0,'award_shift' => 0,'call_id' => $id])->orderBy('order_num', 'ASC')->with('country')->first();
        if ($twilioNumbers) {
                    $userNum = $twilioNumbers->phone_num;
                    $userMessage = $twilioNumbers->country->message; 
                $call = $this->client->account->calls->create(
                    $userNum, // Destination phone number
                    $this->from, // Valid Twilio phone number
                    array(
                        "method" => "GET",
                        "statusCallback" => "https://44d6-122-173-30-38.ngrok-free.app/call_drop/$id",
                        "machineDetection" => "Enable",
                    // "statusCallbackEvent" => ["initiated","answered","no-answer","busy","canceled"],
                        "statusCallbackMethod" => "POST",
                        "twiml" => "<Response>
                        <Say>'".$userMessage."'</Say>
                        <Gather numDigits='1' action = 'https://44d6-122-173-30-38.ngrok-free.app/resopnce_gather/".$id."' method = 'post'>
                        </Gather>
                        </Response>",
        ),);
            
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Twilio\Twiml;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use App\Models\TwilioNumbers;
use App\Models\TwilioCallLists;
use App\Models\TwilioCalls;
use Illuminate\Support\Facades\URL;
use App\Services\AllGatherService;


class IvrController extends Controller
{

    public function __construct(AllGatherService $allGatherService) {
        $this->account_sid = env("TWILIO_SID");
        $this->auth_token = env("TWILIO_AUTH_TOKEN");
        $this->from = env("TWILIO_NUMBER");
        $this->client = new Client($this->account_sid, $this->auth_token);
        $this->allGatherService = $allGatherService;
    }


     public function initiateCall(Request $request) {
      $data = $request->all(); 
      $callerId = $data['call_id'];
     
          try {
            $this->allGatherService->callGather($callerId);
            
          } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
          }


  }
}
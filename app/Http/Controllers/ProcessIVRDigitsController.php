<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Twilio\Twiml;


class ProcessIVRDigitsController extends Controller
{
    public function callFun(Request $request)
    {
        Log::info('app.requests', ['request' => $request->all()]);
        $response = new VoiceResponse();


        $gather = $response->gather(array('numDigits' => 1, 'action' => '/resopnce_gather'));

        $gather->say('Press 1 to take a survey. Press 2 to hear a joke.');

        $response->redirect('/call_Fun');

        header('Content-Type: text/xml');
        echo $response;
    }
}
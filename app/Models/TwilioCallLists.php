<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TwilioCalls;

class TwilioCallLists extends Model
{
    use HasFactory;
    protected $fillable = [
        'call_id',
        'order_num',
        'emp_num',
        'phone_num',
        'emp_resp',
        'twilio_message',
        'pick_time',
        'award_shift',
        'CallTime'
    ];


    public function country()
    {
        return $this->belongsTo(TwilioCalls::class, 'call_id', 'call_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioNumbers extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_name',
        'phone_number',
        'call_preference',
        'call_status',
        'call_completed',
    ];
}

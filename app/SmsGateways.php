<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsGateways extends Model
{
    protected $primaryKey = 'gateway_id';
    protected $table = "sms_gateways";
}

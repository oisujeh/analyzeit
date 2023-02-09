<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentHistoryLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'appointments_logs';

    protected $fillable = [
        'datim_code',
        'pepid',
        'lga',
        'state',
        'phone_no',
        'status'

    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VLPerformance extends Model
{
    use HasFactory;
    public $table = "vl_report";


    protected $fillable = [ ];

    public function scopeState($query,$state)
    {
        if(!Empty($state)){
            $data = explode(',',$state);
            return $query->whereIn('stateCode', $data);
        }
        return $query;
    }

    public function scopeLga($query,$lga)
    {
        if(!Empty($lga)){
            $data = explode(',',$lga);
            return $query->whereIn('lgaCode',$data);
        }
        return $query;
    }

    public function scopeFacilities($query,$fac)
    {
        if(!Empty($fac)){
            $data = explode(',',$fac);
            return $query->whereIn('datim_code',$data);
        }
        return $query;
    }
}

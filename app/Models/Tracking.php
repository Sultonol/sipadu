<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = [
        'complaint_id',
        'latitude',
        'longitude',
        'status'
    ];

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }
}

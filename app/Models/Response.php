<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'complaint_id',
        'user_id',
        'response',
        'status'
    ];

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeByStatus($query, $status){
        return $query->where('status', $status);
    }

}

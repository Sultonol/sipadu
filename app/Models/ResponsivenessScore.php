<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsivenessScore extends Model
{
    protected $fillable = [
        'user_id',
        'total_reports',
        'on_time_resolved',
        'score'
    ];

    protected $table = 'responsivess_scores';

    public function user(){
        return $this->belongsTo(User::class);
    }
}

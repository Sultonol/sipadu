<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspirationVote extends Model
{
    protected $fillable = [
        'aspiration_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class);
    }
}

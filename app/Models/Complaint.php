<?php

namespace App\Models;

use App\Models\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    protected $guarded = [
        'id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function responses(){
        return $this->hasMany(Response::class)->orderBy('created_at', 'desc');
    }

    public function trackings(){
        return $this->hasMany(Tracking::class)->orderBy('created_at', 'desc');
    }

    public function archives(){
        return $this->hasMany(Archive::class)->orderBy('created_at', 'desc');
    }

    public function scopeByStatus($query, $status){
        return $query->where('status', $status);
    }

    public function scopeByCategory($query, $category){
        return $query->where('category', $category);
    }
}

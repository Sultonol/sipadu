<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'complaint_id',
        'content',
        'parent_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }

    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function scopeToplevel($query){
        return $query->whereNull('parent_id');
    }
}

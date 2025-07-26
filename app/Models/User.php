<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function complaints(){
        return $this->hasMany(Complaint::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function archives(){
        return $this->hasMany(Archive::class);
    }

    public function aspirations(){
        return $this->hasMany(Aspiration::class);
    }

    public function apsirationVotes(){
        return $this->hasMany(AspirationVote::class);
    }

    public function responsivenessScore(){
        return $this->hasOne(ResponsivenessScore::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPemerintah()
    {
        return $this->role === 'pemerintah';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}

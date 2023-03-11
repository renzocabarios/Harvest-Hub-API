<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $primarykey = 'id';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function farmer()
    {
        return $this->hasOne(Farmer::class);
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
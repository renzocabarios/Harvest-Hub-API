<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, "id");
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, "id");
    }
}
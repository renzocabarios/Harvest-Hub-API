<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'customer',
        "approved",
        "confirmed",
    ];
}

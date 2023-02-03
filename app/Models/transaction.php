<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'customer',
        "approved",
        "confirmed",
    ];
}

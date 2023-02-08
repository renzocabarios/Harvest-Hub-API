<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'farmer_id',
        'name',
        "description",
        "price",
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, "farmer_id");
    }
}

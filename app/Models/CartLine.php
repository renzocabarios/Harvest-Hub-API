<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartLine extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'product_id',
        "cart_id",
        "quantity",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, "cart_id");
    }
}

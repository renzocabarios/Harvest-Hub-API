<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLine extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'product_id',
        "transaction_id",
        "quantity",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, "transaction_id");
    }
}

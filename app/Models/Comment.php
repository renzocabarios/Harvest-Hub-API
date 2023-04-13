<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'transaction_id',
        'customer_id',
        'quality',
        'accuracy',
        'delivery',
        'feedback',
        'rate',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, "transaction_id");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "id");
    }
}
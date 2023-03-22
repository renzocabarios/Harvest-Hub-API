<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'customer_id',
        "approved",
        "confirmed",
    ];

    protected $attributes = [
        "approved" => false,
        "confirmed" => false,
    ];

    public function transaction_lines()
    {
        return $this->hasMany(TransactionLine::class, "transaction_id");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function transaction()
    {
        return $this->hashOne(Comment::class, "transaction_id");
    }
}
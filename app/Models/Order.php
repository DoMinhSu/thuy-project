<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table= "orders";

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'address',
        'status',
        'total',
        'customer_id'
    ];
    public function customer()
    {
        return $this->belongsTo(customer::class);
    }
}

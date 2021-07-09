<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_name',
        'product_quantity',
        'total',
        'product_id',
        'order_id',
        'price',
    ];
}

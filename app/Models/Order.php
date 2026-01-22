<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'order_id',
        'transaction_id',
        'amount',
        'status',
        'payment_method',
        'address_id',
        'delivery_time',
        'quantity',
        'order_status',
        'length',       // New field
        'breadth',      // New field
        'height',       // New field
        'weight',       // New field
        'shipping_status' // New field
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }


    public function address()
    {
        return $this->belongsTo(Address::class);
    }



}

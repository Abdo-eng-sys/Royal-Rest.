<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $appends = ['customer_name'];
    protected $fillable = [
        'user_id',
        'customer_name',
        'order_name',   // Add this
        'total_price',
        'order_number',
        'total_amount',
        'tax_amount',
        'status',
        'payment_status',
        'delivery_address',
        'phone',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCustomerNameAttribute()
{
    // This automatically "appends" the name from the user relationship
    return $this->user ? $this->user->name : 'Guest';
}
}

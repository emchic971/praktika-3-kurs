<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_date', 'customer_last_name', 'customer_first_name',
        'customer_middle_name', 'total_amount', 'user_id',
    ];

    protected $casts = ['order_date' => 'date'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recalculateTotal(): void
    {
        $this->total_amount = $this->items()->sum('line_total');
        $this->save();
    }
}
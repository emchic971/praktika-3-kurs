<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data) {
            $order = Order::create([
                'order_date' => now(),
                'customer_last_name' => auth()->user()->last_name,
                'customer_first_name' => auth()->user()->first_name,
                'customer_middle_name' => auth()->user()->middle_name,
                'user_id' => auth()->id(),
            ]);

            foreach ($data['items'] as $item) {
                $variant = ProductVariant::findOrFail($item['variant_id']);
                if ($variant->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Недостаточно товара для позиции {$variant->id}",
                    ]);
                }

                $order->items()->create([
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $variant->price,
                    'line_total' => $variant->price * $item['quantity'],
                ]);

                $variant->decrement('stock_quantity', $item['quantity']);
            }
            $order->recalculateTotal();
        });

        return redirect()->route('orders.index')->with('success', 'Заказ оформлен');
    }
}
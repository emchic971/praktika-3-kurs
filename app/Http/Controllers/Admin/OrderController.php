<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $variants = ProductVariant::with('product', 'size')->where('stock_quantity', '>', 0)->get();
        return view('admin.orders.create', compact('users', 'variants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::find($data['user_id']);
            $order = Order::create([
                'order_date' => now(),
                'customer_last_name' => $user->last_name,
                'customer_first_name' => $user->first_name,
                'customer_middle_name' => $user->middle_name,
                'user_id' => $user->id,
            ]);

            foreach ($data['items'] as $item) {
                $variant = ProductVariant::find($item['variant_id']);
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

        return redirect()->route('admin.orders.index')->with('success', 'Заказ добавлен');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Заказ удален');
    }

    public function edit(Order $order)
    {
        $order->load('items');
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'order_date' => 'required|date',
            'customer_last_name' => 'required|string',
            'customer_first_name' => 'required|string',
        ]);
        $order->update($data);
        return redirect()->route('admin.orders.index')->with('success', 'Заказ обновлен');
    }
}
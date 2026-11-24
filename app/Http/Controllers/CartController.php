<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, ProductVariant $variant)
    {
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity'] += $quantity;
        } else {
            $cart[$variant->id] = [
                'product_name' => $variant->product->name,
                'size' => $variant->size->value,
                'quantity' => $quantity,
                'price' => $variant->price,
                'image' => $variant->product->image_path,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Количество обновлено');
        }
    }

    public function remove($variantId)
    {
        if ($variantId) {
            $cart = session()->get('cart');
            if (isset($cart[$variantId])) {
                unset($cart[$variantId]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Товар удален из корзины');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->back()->withErrors('Корзина пуста');

        DB::transaction(function () use ($cart) {
            $order = Order::create([
                'order_date' => now(),
                'customer_last_name' => auth()->user()->last_name,
                'customer_first_name' => auth()->user()->first_name,
                'customer_middle_name' => auth()->user()->middle_name,
                'user_id' => auth()->id(),
            ]);

            foreach ($cart as $id => $details) {
                $variant = ProductVariant::findOrFail($id);
                $order->items()->create([
                    'product_variant_id' => $variant->id,
                    'quantity' => $details['quantity'],
                    'unit_price' => $details['price'],
                    'line_total' => $details['price'] * $details['quantity'],
                ]);
                $variant->decrement('stock_quantity', $details['quantity']);
            }
            $order->recalculateTotal();
        });

        session()->forget('cart');
        return redirect()->route('profile.index')->with('success', 'Заказ успешно оформлен!');
    }
}
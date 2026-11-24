<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Берем пользователя Сидорову
        $user = User::where('login', 'asidorova')->first();
        
        if ($user) {
            $order = Order::create([
                'order_date' => Carbon::parse('2024-02-04'), // Дата с картинки
                'customer_last_name' => $user->last_name,
                'customer_first_name' => $user->first_name,
                'customer_middle_name' => $user->middle_name,
                'user_id' => $user->id,
            ]);

            // Добавляем товары в заказ (Кроссовки, размер 20 и Сандали, размер 22)
            $variant1 = ProductVariant::where('product_id', 1)->whereHas('size', fn($q) => $q->where('value', '20'))->first();
            if ($variant1) {
                $order->items()->create([
                    'product_variant_id' => $variant1->id,
                    'quantity' => 1,
                    'unit_price' => 2190.00,
                    'line_total' => 2190.00,
                ]);
            }

            $variant2 = ProductVariant::where('product_id', 2)->whereHas('size', fn($q) => $q->where('value', '22'))->first();
            if ($variant2) {
                $order->items()->create([
                    'product_variant_id' => $variant2->id,
                    'quantity' => 1,
                    'unit_price' => 2790.00,
                    'line_total' => 2790.00,
                ]);
            }

            $order->recalculateTotal();
        }
    }
}
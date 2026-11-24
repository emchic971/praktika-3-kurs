<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем размеры (из 3-го скриншота)
        $sizeValues = ['18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '44', '45'];
        foreach ($sizeValues as $val) {
            Size::firstOrCreate(['value' => $val]);
        }

        // 2. Создаем категории и подкатегории
        $catChild = Category::firstOrCreate(['name' => 'Детская обувь']);
        $catWomen = Category::firstOrCreate(['name' => 'Женская обувь']);
        $catMen = Category::firstOrCreate(['name' => 'Мужская обувь']);

        $subSneakers = Subcategory::firstOrCreate(['category_id' => $catChild->id, 'name' => 'Кроссовки']);
        $subSandals = Subcategory::firstOrCreate(['category_id' => $catChild->id, 'name' => 'Сандали']);

        // 3. Создаем производителей
        $mans = ['Малыш-Спорт', 'Топ-Топ', 'Лапушка', 'Тёплые ножки', 'Северята', 'Весна', 'Здоровый шаг', 'Карапуз', 'Маленький франт', 'Барбари', 'Твой комфорт', 'Стиль и комфорт', 'Кожевенные традиции', 'Модный силуэт', 'Азимут', 'Берестов'];
        $manufacturers = [];
        foreach ($mans as $m) {
            $manufacturers[$m] = Manufacturer::firstOrCreate(['name' => $m]);
        }

        // 4. Создаем товары и сразу привязываем остатки (из 2-го и 4-го скриншота)
        
        // Пример 1: Кроссовки детские «Звёздочка» эко-кожа
        $p1 = Product::create([
            'category_id' => $catChild->id,
            'subcategory_id' => $subSneakers->id,
            'manufacturer_id' => $manufacturers['Малыш-Спорт']->id,
            'name' => 'Кроссовки детские «Звёздочка» эко-кожа',
            'description' => 'Кроссовки детские «Звёздочка» эко-кожа. Производитель: Малыш-Спорт',
            'composition' => 'Верх — эко-кожа (полиуретан на хлопковой основе), подкладка — хлопок',
            'base_price' => 2190.00,
            'image_path' => 'products/IMG_KS_195217.png'
        ]);
        // Привязываем размеры (20, 21, 22 - по 20 шт)
        foreach (['20', '21', '22'] as $sizeVal) {
            ProductVariant::create([
                'product_id' => $p1->id,
                'size_id' => Size::where('value', $sizeVal)->first()->id,
                'stock_quantity' => 20,
                'price' => 2190.00,
            ]);
        }

        // Пример 2: Сандали детские «Пчёлка» ортопедические летние
        $p2 = Product::create([
            'category_id' => $catChild->id,
            'subcategory_id' => $subSandals->id,
            'manufacturer_id' => $manufacturers['Здоровый шаг']->id,
            'name' => 'Сандали детские «Пчёлка» ортопедические летние',
            'description' => 'Сандали детские «Пчёлка» ортопедические летние.',
            'composition' => 'Верх — нубук натуральный, подкладка — кожа растительного дубления',
            'base_price' => 2790.00,
            'image_path' => 'products/IMG_KS_185508.png'
        ]);
        foreach (['21', '22', '23'] as $sizeVal) {
            ProductVariant::create([
                'product_id' => $p2->id,
                'size_id' => Size::where('value', $sizeVal)->first()->id,
                'stock_quantity' => 4,
                'price' => 2790.00,
            ]);
        }

        // Пример 3: Босоножки «Лесчаный берег» коричневые
        $p3 = Product::create([
            'category_id' => $catWomen->id,
            'subcategory_id' => Subcategory::firstOrCreate(['category_id' => $catWomen->id, 'name' => 'Босоножки'])->id,
            'manufacturer_id' => $manufacturers['Стиль и комфорт']->id,
            'name' => 'Босоножки «Лесчаный берег» коричневые',
            'description' => 'Женские босоножки «Лесчаный берег» коричневые',
            'composition' => 'Коричневая кожаная модель с открытым носком',
            'base_price' => 7500.00,
            'image_path' => 'products/IMG_Wsd_174332.png'
        ]);
        foreach (['36', '37', '38'] as $sizeVal) {
            ProductVariant::create([
                'product_id' => $p3->id,
                'size_id' => Size::where('value', $sizeVal)->first()->id,
                'stock_quantity' => 10,
                'price' => 7500.00,
            ]);
        }
    }
}
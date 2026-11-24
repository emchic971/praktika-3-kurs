<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'subcategory_id', 'manufacturer_id',
        'name', 'image_path', 'composition', 'description', 'base_price',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Subcategory::class); }
    public function manufacturer() { return $this->belongsTo(Manufacturer::class); }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'product_category',
        'product_stock',
    ];

    
    protected $casts = [
        'product_price' => 'decimal:2',  
        'product_stock' => 'integer',
    ];

   
    public function scopeInStock($query)
    {
        return $query->where('product_stock', '>', 0);
    }

    public function scopeInCategory($query, $category)
    {
        return $query->where('product_category', $category);
    }
}
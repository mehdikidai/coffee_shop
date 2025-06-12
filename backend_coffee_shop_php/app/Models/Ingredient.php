<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'unit_name', 'stock', 'price_per_unit', 'stock_threshold'];


    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IngredientProduct extends Model
{
    /** @use HasFactory<\Database\Factories\IngredientProductFactory> */
    use HasFactory;


    protected $table = "ingredient_product";

    protected $fillable = [
        'product_id',
        'ingredient_id',
        'quantity',
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function ingredient(): BelongsTo{
        return $this->belongsTo(Ingredient::class);
    }
}

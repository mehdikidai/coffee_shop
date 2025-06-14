<?php

namespace App\Models;

use App\Models\StockLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipt extends Model
{
    /** @use HasFactory<\Database\Factories\ReceiptFactory> */
    use HasFactory;
    protected $fillable = ['number', 'receipt_photo'];

    public function stockLogs(): HasMany
    {
        return $this->hasMany(StockLog::class);
    }
}

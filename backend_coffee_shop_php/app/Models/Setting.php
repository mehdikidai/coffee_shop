<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = ['key', 'value'];


    public static function boot()
    {


        parent::boot();

        static::updated(function ($setting): void {
            cache()->forget("setting_{$setting->key}");
        });
    }
}

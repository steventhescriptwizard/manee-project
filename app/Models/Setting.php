<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when settings are saved, updated or deleted
        static::saved(function ($setting) {
            Cache::forget('settings.' . $setting->key);
            Cache::forget('settings.all');
        });

        static::deleted(function ($setting) {
            Cache::forget('settings.' . $setting->key);
            Cache::forget('settings.all');
        });
    }
}

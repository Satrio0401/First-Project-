<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function getMultiple(array $keys)
    {
        $settings = static::whereIn('key', $keys)->pluck('value', 'key');
        
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $settings->get($key, null);
        }
        
        return $result;
    }
}

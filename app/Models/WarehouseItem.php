<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WarehouseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'name',
        'qty',
        'price',
        'total_price',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image_path) {
            return null;
        }

        if (Storage::disk('public')->exists($this->image_path)) {
            return Storage::url($this->image_path);
        }

        return asset('storage/' . ltrim($this->image_path, '/'));
    }

    protected static function booted()
    {
        static::saving(function ($item) {
            $item->total_price = $item->qty * $item->price;
        });

        static::deleting(function ($item) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
        });
    }
}

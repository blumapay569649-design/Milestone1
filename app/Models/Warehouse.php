<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'warehouse_user')->withTimestamps();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function invitations()
    {
        return $this->hasMany(WarehouseInvitation::class);
    }

    public function comments()
    {
        return $this->hasMany(WarehouseComment::class)->with('user')->orderBy('created_at', 'desc');
    }

    public function items()
    {
        return $this->hasMany(WarehouseItem::class);
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }
}

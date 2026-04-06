<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_banned',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
        ];
    }

    public function ownedWarehouses()
    {
        return $this->hasMany(Warehouse::class, 'owner_id');
    }

    public function sharedWarehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_user')->withTimestamps();
    }

    public function sentInvitations()
    {
        return $this->hasMany(WarehouseInvitation::class, 'inviter_id');
    }

    public function receivedInvitations()
    {
        return $this->hasMany(WarehouseInvitation::class, 'invitee_id');
    }

    public function comments()
    {
        return $this->hasMany(WarehouseComment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isBanned(): bool
    {
        return $this->is_banned;
    }

    public function canAccessWarehouse(Warehouse $warehouse): bool
    {
        return $this->isAdmin()
            || $warehouse->isOwnedBy($this)
            || $warehouse->hasMember($this);
    }
}

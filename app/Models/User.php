<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Publisher;
use App\Models\Library;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'Dashboard_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin'     => $this->role === 'admin',
            'publisher' => $this->role === 'publisher',
            'library'   => $this->role === 'library',
            default     => false,
        };
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function publisherProfile()
    {
        // العلاقة بين المستخدم وحساب الناشر
        return $this->hasOne(Publisher::class, 'user_id');
    }

    public function libraryProfile()
    {
        return $this->hasOne(Library::class, 'user_id');
    }

 protected static function booted()
{
    static::created(function ($user) {

        if ($user->role === 'publisher') {
            Publisher::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'approved' => 1,
            ]);
        }

        if ($user->role === 'library') {
            Library::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'approved' => 1,
            ]);
        }

    });
}
}

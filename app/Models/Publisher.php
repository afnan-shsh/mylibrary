<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'approved',
        'user_id',
    ];

    public function books()
{
    return $this->hasMany(Book::class, 'publisher_id', 'user_id');
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

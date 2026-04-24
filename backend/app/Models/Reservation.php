<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'date',
        'time',
        'guests',
        'special_requests',
        'status',
        'table_number',
    ];

    protected $casts = [
        'date' => 'date',
        'guests' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'rooms_type_id',
        'price_per_night',
        'capacity',
        'description'
    ];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'rooms_type_id', 'id');
    }
}

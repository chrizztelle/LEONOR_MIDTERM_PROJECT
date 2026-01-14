<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'room_number',
        'rooms_type_id',
        'price_per_night',
        'capacity',
        'description',
        'photo',
    ];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'rooms_type_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $primaryKey = 'id';

    protected $fillable = [
        'building_id',
        'name',
        'floor_number',
        'type',
        'unit_price',
        'member_count',
        'status'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function residence()
    {
        return $this->hasMany(Residence::class, 'room_id', 'id');
    }

    public function object(): MorphOne
    {
        return $this->morphOne(Notification::class, 'objective');
    }

    public function room_assets()
    {
        return $this->hasMany(RoomAsset::class, 'room_id', 'id');
    }


}

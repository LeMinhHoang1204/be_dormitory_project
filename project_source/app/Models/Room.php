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

    // notification relationship
    public function object(): MorphOne
    {
        return $this->morphOne(Notification::class, 'object');
    }

    // building relationship
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    // residence relationship
    public function residence()
    {
        return $this->hasMany(Residence::class, 'room_id', 'id');
    }

    public function latestResidence()
    {
        return $this->hasOne(Residence::class, 'room_id', 'id')
            ->whereNotIn('status', ['Checked out', 'Transfered'])
            ->latest('start_date');
    }

    // room asset relationship
    public function hasRoomAssets()
    {
        return $this->hasMany(RoomAsset::class, 'room_id', 'id');
    }

    // invoice relationship
    public function invoice(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Invoice::class, 'object');
    }


}

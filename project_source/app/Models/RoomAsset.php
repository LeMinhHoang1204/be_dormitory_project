<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAsset extends Model
{
    use HasFactory;

    protected $table = 'room_assets';

    protected $primaryKey = 'id';

    protected $fillable = [
        'room_id',
        'asset_id',
        'quantity',
        'status',
        'issue_date',
        'return_date',
        'note'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

}

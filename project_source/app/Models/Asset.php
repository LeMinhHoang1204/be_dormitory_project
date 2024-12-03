<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'quantity',
        'note'
    ];

    public function room_assets()
    {
        return $this->hasMany(RoomAsset::class, 'asset_id', 'id');
    }

}

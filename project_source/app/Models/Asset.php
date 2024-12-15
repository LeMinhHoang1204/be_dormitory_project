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

    public function RoomAssets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RoomAsset::class, 'asset_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Building extends Model
{
    use HasFactory;

    protected $table = 'buildings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'building_manager_id',
        'type',
        'floor_numbers',
        'room_numbers',
        'student_count'
    ];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'building_manager_id', 'id');
    }

    public function room()
    {
        return $this->hasMany(Room::class, 'building_id', 'id');
    }

    public function object(): MorphOne
    {
        return $this->morphOne(Notification::class, 'objective');
    }
}

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
        'manager_id',
        'type',
        'floor_numbers',
        'room_numbers',
        'student_count'
    ];

    // employee relationship
    public function managedBy()
    {
        return $this->belongsTo(Employee::class, 'manager_id', 'id');
    }

    // room relationship
    public function hasRooms()
    {
        return $this->hasMany(Room::class, 'building_id', 'id');
    }

    // notification relationship
    public function object(): MorphOne
    {
        return $this->morphOne(Notification::class, 'object');
    }

    // invoice relationship
    public function invoice(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Invoice::class, 'object');
    }

}

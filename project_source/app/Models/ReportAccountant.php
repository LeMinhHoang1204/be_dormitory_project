<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReportAccountant extends Model
{
    use HasFactory;
    protected $table = 'student';

    protected $fillable = [
        'student_id',
        'room_id',
        'month',
        'year',
        'status',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function buildings()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function object(): MorphTo
    {
        return $this->morphTo();
    }

}

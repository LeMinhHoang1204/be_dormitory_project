<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use HasFactory;

    protected $table = 'residences';

//    protected $primaryKey = ['stu_id', 'room_id', 'start_date'];

    protected $fillable = [
        'stu_user_id',
        'room_id',
        'start_date',
        'end_date',
        'check_out_date',
        'status',
        'note'
    ];

    // Quan hệ với Student
    public function user()
    {
        return $this->belongsTo(User::class, 'stu_user_id', 'id');
    }

    // Quan hệ với Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}

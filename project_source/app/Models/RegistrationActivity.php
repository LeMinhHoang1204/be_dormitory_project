<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'participant_id',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        $statuses = [
            'Registered' => 'Registered',
            'Joined' => 'Joined',
            'Cancelled' => 'Cancelled',
        ];

//        return $statuses[$value] ?? 'Not participated';
        return $statuses[$value] ?? 'Not Registered';
    }


    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id', 'id');
    }
    public function residence()
    {
        return $this->hasOne(Residence::class, 'stu_user_id', 'participant_id');
    }

}

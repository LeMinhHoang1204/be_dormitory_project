<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'register_end_date',
        'max_participants',
        'registered_participants',
        'ticket_price',
        'bonus_point',
        'status',
        'note',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function hasParticipants()
    {
        return $this->hasMany(RegistrationActivity::class, 'activity_id', 'id')
            ->with('participant');
    }
    protected $dates = [
        'start_date', 'end_date', 'register_end_date',
    ];

//    public function participants()
//    {
//        return $this->belongsToMany(User::class, 'registration_activities', 'activity_id', 'participant_id');
//    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'registration_activities', 'activity_id', 'participant_id')
            ->withPivot('status')
            ->withTimestamps();
    }

}

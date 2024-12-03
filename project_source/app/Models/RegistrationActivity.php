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

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id', 'id');
    }
}

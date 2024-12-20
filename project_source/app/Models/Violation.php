<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;


    protected $fillable = [
        'creator_id',
        'receiver_id',
        'type',
        'title',
        'description',
        'occurred_at',
        'status',
        'minus_point',
        'note',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
    public function complaints()
    {
        return $this->hasMany(ComplaintViolation::class, 'violation_id', 'id');
    }
}

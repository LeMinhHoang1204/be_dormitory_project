<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type',
        'status',
        'resolve_date',
        'note',
        'forward_id',
        'evidence_image',
    ];

    protected $casts = [
        'resolve_date' => 'datetime',

    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function forwarder()
    {
        return $this->belongsTo(User::class, 'forwarder_id');
    }
}

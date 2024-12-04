<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type',
        'status',
        'send_date',
        'receive_date',
        'resolve_date',
        'note',
        'forward_id',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';

    public $fillable = [
        'sender_id',
        'object_id',
        'object_type',
        'title',
        'content',
        'reader_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function readBy()
    {
        return $this->hasMany(NotificationRecipient::class, 'noti_id', 'id');
    }

    // user relationship
    public function sender(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    // object relationship: user, building, room
    public function object(): MorphTo
    {
        return $this->morphTo();
    }
}

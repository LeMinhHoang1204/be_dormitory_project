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
        'title',
        'type',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function object()
    {
        return $this->hasMany(NotificationRecipient::class, 'noti_id', 'id');
    }

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    // quan he 1-1 voi User, Building, Room
    public function objective(): MorphTo
    {
        return $this->morphTo();
    }
}

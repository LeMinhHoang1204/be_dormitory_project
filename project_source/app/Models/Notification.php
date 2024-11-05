<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'sender_id',
        'type',
        'content',
    ];

    public function recipients()
    {
        return $this->hasMany(NotificationRecipient::class, 'noti_id', 'id');
    }
}

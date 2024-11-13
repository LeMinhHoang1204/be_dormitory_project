<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationRecipient extends Model
{
    use HasFactory;

    protected $table = 'NOTIFICATION_RECIPIENTS';

//    protected $primaryKey = ['noti_id', 'user_id'];

    public $timestamps = false;

    protected $fillable = [
        'noti_id',
        'user_id',
    ];

    public function notification()
    {
        return $this->belongsTo(NotificationRecipient::class, 'noti_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

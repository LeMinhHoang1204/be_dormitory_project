<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'object_type',
        'object_id',
        'start_date',
        'send_date',
        'due_date',
        'paid_date',
        'type',
        'total',
        'status',
        'payment_method',
        'evidence_image',
        'note',
    ];

    // user relationship
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    // object relationship: user, building, room
    public function object(): MorphTo
    {
        return $this->morphTo();
    }

    public function hasItems()
    {
        return $this->hasMany(DetailInvoice::class, 'invoice_id', 'id');
    }
}

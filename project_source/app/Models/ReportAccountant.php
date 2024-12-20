<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReportAccountant extends Model
{
    use HasFactory;

    protected $table = 'report_accountants';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function object(): MorphTo
    {
        return $this->morphTo();
    }

}

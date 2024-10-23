<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';

    protected $fillable = ['STU_USER_ID', 'STU_UNI_ID', 'STU_NAME',
            'STU_UNI_NAME', 'STU_DOB', 'STU_GENDER'];

    // Thiết lập mối quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'STU_USER_ID');
    }
}

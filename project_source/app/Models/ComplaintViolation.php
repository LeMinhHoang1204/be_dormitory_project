<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'violation_id',
        'student_id',
        'creator_id',
        'complaint_description',
        'status',
    ];

    // Quan hệ với Violation
    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id', 'id');
    }

    // Quan hệ với Student (Người khiếu nại)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}

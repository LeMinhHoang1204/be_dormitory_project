<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Residence extends Model
{
    use HasFactory;

    protected $table = 'residences';

//    protected $primaryKey = ['stu_id', 'room_id', 'start_date'];

    protected $fillable = [
        'stu_user_id',
        'room_id',
        'start_date',
        'end_date',
        'check_out_date',
        'status',
        'note',
        'months_months_duration',
    ];

    // Quan hệ với Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'stu_user_id', 'id');
    }

    // Quan hệ với Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    //tự động tính toán end_date
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($residence) {
            if ($residence->start_date && $residence->months_duration) {
                $residence->end_date = self::calculateEndDate($residence->start_date, $residence->months_duration);
            }
        });

        static::updating(function ($residence) {
            if ($residence->start_date && $residence->months_duration) {
                $residence->end_date = self::calculateEndDate($residence->start_date, $residence->months_duration);
            }
        });
    }

    /**
     * Tính toán end_date dựa trên start_date và months_duration.
     */
    public static function calculateEndDate($startDate, $months_duration)
    {
        $int_months_duration = (int)$months_duration;
        return Carbon::parse($startDate)->addMonths($int_months_duration);
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

}

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
        'duration',
    ];

    // Quan hệ với Student
    public function user()
    {
        return $this->belongsTo(User::class, 'stu_user_id', 'id');
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
            if ($residence->start_date && $residence->duration) {
                $residence->end_date = self::calculateEndDate($residence->start_date, $residence->duration);
            }
        });

        static::updating(function ($residence) {
            if ($residence->start_date && $residence->duration) {
                $residence->end_date = self::calculateEndDate($residence->start_date, $residence->duration);
            }
        });
    }

    /**
     * Tính toán end_date dựa trên start_date và duration.
     */
    private static function calculateEndDate($startDate, $duration)
    {
        $months = [
            '3 months' => 3,
            '6 months' => 6,
            '9 months' => 9,
            '12 months' => 12,
        ];

        $monthsToAdd = $months[$duration] ?? 0;

        return Carbon::parse($startDate)->addMonths($monthsToAdd);
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

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'months_duration',
    ];

    // Quan hệ với Student
    public function student()
    {
        return $this->belongsTo(User::class, 'stu_user_id', 'id');
    }

    // Quan hệ với Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function latestResidence()
    {
        return $this->hasOne(Residence::class, 'stu_user_id', 'id')
            ->whereNotIn('status', ['Checked out', 'Transfered'])
            ->latest('start_date');
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

//        static::updating(function ($residence) {
//            if ($residence->start_date && $residence->months_duration) {
//                $residence->end_date = self::calculateEndDate($residence->start_date, $residence->months_duration);
//            }
//        });

        static::updating(function ($residence) {
            if ($residence->isDirty('status') && in_array($residence->status, ['Checked out', 'Rejected', 'Transfered', 'Changed Room'])) {
                $residence->updateRoomAndBuildingCounts(-1);
            }
        });


        static::created(function ($residence) {
            $residence->updateRoomAndBuildingCounts(1);
        });

//        static::deleted(function ($residence) {
//            $residence->updateRoomAndBuildingCounts(-1);
//        });
    }

    /**
     * Tính toán end_date dựa trên start_date và months_duration.
     */
    public static function calculateEndDate($startDate, $months_duration)
    {
        $int_months_duration = (int) $months_duration;
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

    public function updateRoomAndBuildingCounts($count)
    {
        if ($this->room) {
            $this->room->increment('member_count', $count);
            $this->room->building->increment('student_count', $count);
        }
        else {
            $this->room->decrement('member_count', abs($count));
            $this->room->building->decrement('student_count', abs($count));
        }
    }

}

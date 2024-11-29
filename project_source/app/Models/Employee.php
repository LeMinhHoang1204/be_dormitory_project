<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory; // tinh nang tao du lieu mau cua Factory trong laravel
    // mac dinh se luu trong students table
    // cu the table trong db
    protected $table = 'employees';

    // mac dinh Eloquent se hieu attribute id la primary key
    // neu khac, phai cu the
    protected $primaryKey = 'id';

    // Các attribute được phép thêm vào db
    protected $fillable = ['user_id', 'manager_id',
        'citizen_id', 'dob', 'gender', 'type'];

    protected $casts = [
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Thiết lập mối quan hệ với User
    public function user()
    {
        // foreign key: khoá ngoại của student không phải là "user_id"
        // ownerKey: nếu khoá chính của user không phải là "id"
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function manager(){
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }

    public function manage()
    {
        return $this->hasOne(Building::class, 'manager_id', 'id');
    }
}

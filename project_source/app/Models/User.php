<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    // App\Models\User.php
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }


    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(NotificationRecipient::class, 'user_id', 'id');
    }

    public function send_notification()
    {
        return $this->hasMany(Notification::class, 'sender_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function object(): MorphOne
    {
        return $this->morphOne(Notification::class, 'objective');
    }

    public function manager(){
        return $this->hasMany(Employee::class, 'manager_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'stu_id', 'id'); // 'stu_id' là cột khóa ngoại trong bảng rooms liên kết với bảng users
    }

    public function sendInvoice()
    {
        return $this->hasMany(Invoice::class, 'sender_id', 'id');
    }

    public function hasParticipate()
    {
        return $this->hasMany(RegistrationActivity::class, 'participant_id', 'id');
    }

    public function createViolation()
    {
        return $this->hasMany(Invoice::class, 'creator_id', 'id');
    }

    public function receiveViolation()
    {
        return $this->hasMany(Invoice::class, 'receiver_id', 'id');
    }
}

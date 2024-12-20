<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public static function getSpecificUser($id)
    {
        return User::find($id);
    }



    // student relationships
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }



    // employee relationships
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function manageEmployee(){
        return $this->hasMany(Employee::class, 'manager_id', 'id');
    }



    // notification recipient relationships
    public function read()
    {
        return $this->hasMany(NotificationRecipient::class, 'user_id', 'id');
    }



    // notification relationships
    public function senderNotification()
    {
        return $this->hasMany(Notification::class, 'sender_id', 'id');
    }

    // object notification relationship
    public function notification(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Notification::class, 'object');
    }



    // residence relationships
    public function residence(){
        return $this->hasMany(Residence::class, 'stu_user_id', 'id');
    }

    public function latestResidence()
    {
        return $this->hasOne(Residence::class, 'stu_user_id', 'id')
            ->whereNotIn('status', ['Checked out', 'Transfered'])
            ->latest('start_date');
    }



    // request relationships
    public function sendRequest()
    {
        return $this->hasMany(Request::class, 'sender_id', 'id');
    }

    public function receiveRequest()
    {
        return $this->hasMany(Request::class, 'receiver_id', 'id');
    }

    public function forwardRequest()
    {
        return $this->hasMany(Request::class, 'forwarder_id', 'id');
    }



    // invoice relationships
    public function sendInvoice()
    {
        return $this->hasMany(Invoice::class, 'sender_id', 'id');
    }

    public function invoice(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Invoice::class, 'object');
    }



    // activity relationships
    public function createActivity()
    {
        return $this->hasMany(Activity::class, 'creator_id', 'id');
    }

    public function hasParticipated()
    {
        return $this->hasMany(RegistrationActivity::class, 'participant_id', 'id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'registration_activities', 'participant_id', 'activity_id')
            ->withPivot('status')
            ->withTimestamps();
    }


    // violation relationships
    public function createViolation()
    {
        return $this->hasMany(Violation::class, 'creator_id', 'id');
    }

    public function receiveViolation()
    {
        return $this->hasMany(Violation::class, 'receiver_id', 'id');
    }

}

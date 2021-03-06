<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'patronymic',
        'email', 'password', 'status_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email', 'created_at', 'updated_at',
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be guarder from write
     *
     * @var array
     */

    protected $guarded = [
        'remember_token'
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}

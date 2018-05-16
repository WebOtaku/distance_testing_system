<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function cicle()
    {
        return $this->hasOne(Cicle::class);
    }
}

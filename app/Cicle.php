<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'speciality_id', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }
}

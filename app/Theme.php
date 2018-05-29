<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'discipline_teacher_id', 'name', 'course'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function disciplineTeacher()
    {
        return $this->belongsTo(DisciplineTeacher::class);
    }
}

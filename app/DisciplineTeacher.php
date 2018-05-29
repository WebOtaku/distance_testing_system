<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisciplineTeacher extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id', 'discipline_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
}

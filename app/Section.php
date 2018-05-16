<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discipline_id', 'teacher_id', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
}

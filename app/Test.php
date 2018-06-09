<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'speciality_id', 'theme_id', 'teacher_id', 'name', 'number_questions',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /*TODO: Сделать так что бы обновлялось поле updated_at*/

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function completedTests()
    {
        return $this->hasMany(CompletedTest::class);
    }

    public function scoreScales()
    {
        return $this->hasMany(ScoreScale::class);
    }
}

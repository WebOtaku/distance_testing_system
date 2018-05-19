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
        'theme_id', 'name', 'number_questions',
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

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function completedTests()
    {
        return $this->hasMany(CompletedTest::class);
    }

    public function scoreScale()
    {
        return $this->hasOne(ScoreScale::class);
    }
}

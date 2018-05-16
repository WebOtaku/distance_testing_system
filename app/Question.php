<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_id', 'question_type_id', 'question'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function answerVariants()
    {
        return $this->hasMany(AnswerVariant::class);
    }
}

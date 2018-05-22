<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerVariant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'answer', 'correct_answer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

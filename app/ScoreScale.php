<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreScale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_id', 'from', 'to', 'score'
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
}

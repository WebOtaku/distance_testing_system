<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cicle_id', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function cicle()
    {
        return $this->belongsTo(Cicle::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}

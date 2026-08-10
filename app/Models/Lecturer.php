<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'name',
        'expertise',
        'photo',
    ];

    public function expertises()
    {
        return $this->belongsToMany(Expertise::class, 'lecturer_expertise');
    }
}

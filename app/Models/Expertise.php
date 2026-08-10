<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $table = 'expertises';

    protected $fillable = [
        'name',
        'category', // dev, data, gov, other
    ];

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'lecturer_expertise');
    }
}

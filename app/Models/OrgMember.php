<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'nip',
        'photo',
        'sort_order',
    ];
}

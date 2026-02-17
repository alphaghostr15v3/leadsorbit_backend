<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'image_url',
        'bio',
        'linkedin',
        'twitter',
        'github',
        'facebook',
        'instagram',
        'cv_url',
        'order'
    ];
}

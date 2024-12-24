<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $fillable = [
        'image', 'title', 'description', 'link_one', 'link_two', 'priority'
    ];
}

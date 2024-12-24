<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unduhan extends Model
{
    protected $fillable = [
        'title', 'description', 'filename', 'mimeType', 'size', 'view_count', 'download_count'
    ];
}

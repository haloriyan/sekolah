<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_id', 'filename', 'mediaType'
    ];

    public function gallery() {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}

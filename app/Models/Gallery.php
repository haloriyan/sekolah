<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'type', 'title', 'slug', 'description'
    ];

    public function images() {
        return $this->hasMany(GalleryImage::class, 'gallery_id');
    }
    public function image() {
        return $this->hasOne(GalleryImage::class, 'gallery_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setImageAttribute($image)
    {
        $newImageName = uniqid().'_'.'announcements_image'.'.'.$image->extension();
        $image->move(public_path('announcements_image'), $newImageName);

        return $this->attributes['image'] = '/'.'announcements_image'.'/'.$newImageName;
    }

    public function publicAnnouncement()
    {
        return $this->belongsTo(PublicAnnouncement::class);
    }
}

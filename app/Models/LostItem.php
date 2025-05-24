<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setImageAttribute($image)
    {
        $newImageName = uniqid().'_'.'lostItems_image'.'.'.$image->extension();
        $image->move(public_path('lostItems_image'), $newImageName);

        return $this->attributes['image'] = '/'.'lostItems_image'.'/'.$newImageName;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setImageAttribute($image)
    {
        $newImageName = uniqid().'_'.'lostItems_image'.'.'.$image->extension();
        $image->move(public_path('lostItems_image'), $newImageName);

        return $this->attributes['image'] = '/'.'lostItems_image'.'/'.$newImageName;
    }

    /**
     * Parent comment (nullable).
     * A reply will belong to one parent comment.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Child comments (replies).
     * A comment can have many replies.
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->orderBy('created_at', 'asc');
    }

    public function lostItem()
    {
        return $this->belongsTo(LostItem::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

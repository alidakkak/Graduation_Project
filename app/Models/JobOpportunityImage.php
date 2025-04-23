<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpportunityImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setImageAttribute($image)
    {
        $newImageName = uniqid().'_'.'JobOpportunities_image'.'.'.$image->extension();
        $image->move(public_path('JobOpportunities_image'), $newImageName);

        return $this->attributes['image'] = '/'.'JobOpportunities_image'.'/'.$newImageName;
    }

    public function jobOpportunity()
    {
        return $this->belongsTo(JobOpportunity::class);
    }
}

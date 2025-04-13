<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $guard = 'api_student';

    public function setImageAttribute($image)
    {
        $newImageName = uniqid().'_'.'students_image'.'.'.$image->extension();
        $image->move(public_path('students_image'), $newImageName);

        return $this->attributes['image'] = '/'.'students_image'.'/'.$newImageName;
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;
    use HasFactory,SoftDeletes;

    public function setBodyAttribute($body)
    {
        if ($this->type === 'attachment' && $body instanceof \Illuminate\Http\UploadedFile) {
            // تأكد من وجود المجلد
            $destination = public_path('attachment');
            if (! file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $newImageName = Str::uuid().'.attachment.'.$body->getClientOriginalExtension();
            $body->move($destination, $newImageName);

            $this->attributes['body'] = 'attachment/'.$newImageName;
        } else {
            $this->attributes['body'] = $body;
        }
    }

    protected $fillable = ['student_id', 'type', 'body', 'conversation_id'];

    public function sender()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'student_id');
    }

    public function recipients()
    {
        return $this->hasMany(Recipient::class);

    }
}

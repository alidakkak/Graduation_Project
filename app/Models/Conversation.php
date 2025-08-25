<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'label', 'type', 'last_message_id', 'avatar', 'description'];

    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id', 'id')
            ->where('hate',0)
            ->whereNull('deleted_at');

    }

    public function recipients()
    {
        return $this->hasManyThrough(
            Recipient::class,
            Message::class,
            'conversation_id',
            'message_id',
            'id',
            'id'
        );
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'members');
    }

    public function members()
    {
        return $this->belongsToMany(Student::class, Member::class);

    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

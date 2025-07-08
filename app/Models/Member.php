<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'student_id', 'is_block', 'is_mute', 'is_pinned', 'is_archived', 'role', 'joined_at'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}

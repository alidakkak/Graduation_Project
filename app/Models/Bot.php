<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'message', 'answer'];

    public function sender()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'exam_code', 'name', 'is_active', 'duration'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

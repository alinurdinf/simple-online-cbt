<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'participant', 'user_id', 'score', 'exam_code', 'exam_name', 'duration', 'attempt_time', 'end_time'
    ];
}

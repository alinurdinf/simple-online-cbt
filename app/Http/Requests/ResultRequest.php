<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'participant' => 'required',
            'is_active' => 'required',
            'exam_name' => 'required',
            'exam_code' => 'required|exists:exams,exam_code',
            'score' => '',
            'duration' => '',
            'attempt_time' => '',
            'end_time' => '',

        ];
    }
}

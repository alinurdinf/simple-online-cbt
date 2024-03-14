<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(QuestionRequest $questionRequest)
    {
        $data = $questionRequest->all();

        $question = Question::create([
            'exam_id' => $data['exam_id'],
            'question' => $data['question'],
            'correct_answer' => $data['correct_answer'],
        ]);

        $choices = $data['choices'];
        $choiceModels = [];

        foreach ($choices as $choice) {
            $choiceModels[] = new Choice([
                'choice' => $choice,
            ]);
        }

        $question->save();

        $question->choices()->saveMany($choiceModels);

        return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function destroy($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $choice = Choice::where('question_id', $id)->delete();
        $question = Question::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus');
    }
}

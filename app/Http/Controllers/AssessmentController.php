<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssessmentRequest;
use App\Http\Requests\ResultRequest;
use App\Models\Exam;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.assessment.index');
    }

    public function assessment_check(AssessmentRequest $request)
    {
        $data = Exam::where('exam_code', $request->exam_code)->first();
        session()->put('exam_data', $data);
        return redirect()->route('assessment.assessment_home');
    }

    public function assessment_home()
    {
        $data = session()->get('exam_data');
        return view('pages.dashboard.assessment.home', compact('data'));
    }

    public function assessment_store(ResultRequest $resultRequest)
    {
        TestResult::create([
            'user_id' => $resultRequest->user_id,
            'participant' => $resultRequest->participant,
            'exam_code' => $resultRequest->exam_code,
            'exam_name' => $resultRequest->exam_name,
            'score' => 0,
            'attempt_time' => now(),
        ]);

        return redirect()->route('assessment.assessment_index')->with('suceess', 'Selemat Mengerjakan');
    }


    public function assessment_index()
    {
        $data = session()->get('exam_data');
        $questions = Question::where('exam_id', $data->id)->with('choices')->get();
        return view('pages.dashboard.assessment.assessment', compact('data', 'questions'));
    }

    public function assessment_update(Request $request)
    {
        $data = $request->all();
        $correctAnswers = 0;
        $totalQuestions = 0;

        foreach ($data as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $questionId = $value;
                $choice = $data['answer_' . $questionId];

                $question = Question::find($questionId);

                if ($question && $question->correct_answer === $choice) {
                    $correctAnswers++;
                }

                $totalQuestions++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        $TestResult = TestResult::where('user_id', auth()->user()->id)
            ->where('exam_code', $request->exam_code)
            ->latest()
            ->first();

        $TestResult->score = $score;
        $TestResult->end_time = now();
        $durationInSeconds = $TestResult->end_time->diffInSeconds($TestResult->attempt_time);

        $durationString = floor($durationInSeconds / 60) . ' menit';

        $TestResult->duration = $durationString;
        $TestResult->save();

        $TestResult = $TestResult->refresh();

        return redirect()->route('assessment.assessment_result')->with('success', 'Good Luck');
    }

    public function assessment_result()
    {
        $data = session()->get('exam_data');
        $result = TestResult::where('user_id', auth()->user()->id)
            ->where('exam_code', $data->exam_code)
            ->latest()
            ->first();

        return view('pages.dashboard.assessment.result', compact('data', 'result'));
    }

    public function assessment_finish()
    {
        session()->forget('exam_data');
        return redirect()->route('assessment.index');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $exam_name = $request->input('exam_name');
        $exam_code = $request->input('exam_code');

        if ($id) {
            $category = Exam::with(['questions'])->find($id);

            if ($category)
                return ResponseFormatter::success(
                    $category,
                    'Data exam berhasil diambil'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'Data exam tidak ada',
                    404
                );
        }
        $exam = Exam::with(['questions']);

        if ($exam_name)
            $exam->where('exam_name', 'like', '%' . $exam_name . '%');

        if ($exam_code)
            $exam->where('exam_code', $exam_code);

        return ResponseFormatter::success(
            $exam->paginate($limit),
            'Data list exam berhasil diambil'
        );
    }
}

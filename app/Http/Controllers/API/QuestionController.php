<?php

namespace App\Http\Controllers\API;

use App\Models\question;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);

        if ($id) {
            $category = Question::with(['choices'])->find($id);

            if ($category)
                return ResponseFormatter::success(
                    $category,
                    'Data question berhasil diambil'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'Data question tidak ada',
                    404
                );
        }
        $question = Question::with(['choices']);

        return ResponseFormatter::success(
            $question->paginate($limit),
            'Data list question berhasil diambil'
        );
    }
}

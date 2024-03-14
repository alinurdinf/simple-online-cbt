<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Choice;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use Illuminate\Cache\RedisTagSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Exam::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                            href="' . route('exam.show', $item->id) . '">
                            Show Detail
                        </a>
                        <form class="inline-block" action="' . route('exam.destroy', encrypt($item->id)) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->addColumn('is_active', function ($item) {
                    return $item->is_active ? 'Active' : 'In-Active';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.exam.index');
    }

    public function create()
    {
        return view('pages.dashboard.exam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExamRequest $request)
    {
        $data = $request->all();
        Exam::create($data);

        return redirect()->route('exam.index');
    }

    public function show(Exam $exam)
    {
        if (request()->ajax()) {
            $query = Question::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                            href="#">
                           Edit
                        </a>
                        <form class="inline-block" action="' . route('question.destroy', encrypt($item->id)) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        $data = User::all();
        return view('pages.dashboard.exam.show', compact('exam'));
    }

    public function destroy($encrypted_id)
    {
        $id = decrypt($encrypted_id);

        $questions = Question::where('exam_id', $id)->get();

        foreach ($questions as $question) {
            foreach ($question->choices as $choice) {
                $choice->delete();
            }
            $question->delete();
        }

        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Exam berhasil dihapus');
    }
}
